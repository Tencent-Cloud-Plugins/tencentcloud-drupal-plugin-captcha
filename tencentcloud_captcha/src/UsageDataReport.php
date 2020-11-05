<?php
/**
 * Copyright (C) 2020 Tencent Cloud.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Drupal\tencentcloud_captcha;

class UsageDataReport
{
    const REPORT_URL = 'https://appdata.qq.com/upload';
    private $secretId;
    private $secretKey;

    public function __construct($secret_id = '', $secret_key = '')
    {
        $this->secretId = $secret_id;
        $this->secretKey = $secret_key;
    }

    private function setSignatureHeaders()
    {
        $headers = array();
        $service = 'ms';
        $timestamp = time();
        $algo = 'TC3-HMAC-SHA256';
        $headers['Host'] = 'ms.tencentcloudapi.com';
        $headers['X-TC-Action'] = 'DescribeUserBaseInfoInstance';
        $headers['X-TC-RequestClient'] = 'SDK_PHP_3.0.187';
        $headers['X-TC-Timestamp'] = $timestamp;
        $headers['X-TC-Version'] = '2018-04-08';
        $headers['Content-Type'] = 'application/json';

        $canonicalHeaders = 'content-type:' . $headers['Content-Type'] . "\n" . 'host:' . $headers['Host'] . "\n";
        $canonicalRequest = "POST\n/\n\n" . $canonicalHeaders . "\n" . "content-type;host\n" . hash('SHA256', '{}');
        $date = gmdate('Y-m-d', $timestamp);
        $credentialScope = $date . '/' . $service . '/tc3_request';
        $str2sign = $algo . "\n" . $headers['X-TC-Timestamp'] . "\n" . $credentialScope . "\n" . hash('SHA256', $canonicalRequest);

        $dateKey = hash_hmac('SHA256', $date, 'TC3' . $this->secretKey, true);
        $serviceKey = hash_hmac('SHA256', $service, $dateKey, true);
        $reqKey = hash_hmac('SHA256', 'tc3_request', $serviceKey, true);
        $signature = hash_hmac('SHA256', $str2sign, $reqKey);

        $headers['Authorization'] = $algo . ' Credential=' . $this->secretId . '/' . $credentialScope .
            ', SignedHeaders=content-type;host, Signature=' . $signature;
        $this->headers = array();
        foreach ($headers as $name => $value) {
            $this->headers[] = $name . ': ' . $value;
        }
    }

    public function getUin()
    {
        if ($this->secretId === '' || $this->secretKey === '') {
            return '';
        }
        $this->setSignatureHeaders();
        $this->params = '{}';
        $stream = $this->getStream('https://ms.tencentcloudapi.com');
        $result = stream_get_contents($stream, -1);
        fclose($stream);
        $result = json_decode(trim($result));
        if (!is_object($result) || !isset($result->Response->UserUin)) {
            return '';
        }
        return $result->Response->UserUin;
    }

    private function getOption()
    {
        return array(
            'http' =>
                array(
                    'method' => 'POST',
                    'protocol_version' => 1.1,
                    'timeout' => 1.0,
                    'ignore_errors' => true,
                    'header' => $this->headers,
                    'content' => $this->params
                )
        );
    }

    private function getStream($url)
    {
        $context = stream_context_create($this->getOption());
        return fopen($url, 'r', false, $context);
    }

    private function setSimpleHeaders()
    {
        $this->headers = array(
            'Content-Type: application/json',
        );
    }

    public function reportByStream($data)
    {
        $this->setSimpleHeaders();
        $this->params = json_encode($data);
        $stream = $this->getStream(self::REPORT_URL);
        stream_set_blocking($stream, false);
        stream_get_contents($stream, -1);
        fclose($stream);
    }

    public function report($data)
    {
        $data['data']['uin'] = $this->getUin();
        if (function_exists('curl_init')) {
            ob_start();
            $json_data = json_encode($data);
            $curl = curl_init(self::REPORT_URL);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-type: application/json"));
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $json_data);
            curl_setopt($curl, CURLOPT_TIMEOUT, 60);   //设置一秒超时
            curl_exec($curl);
            curl_exec($curl);
            curl_close($curl);
            ob_end_clean();
        } else {
            $this->reportByStream($data);
        }
    }
}
