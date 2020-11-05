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
namespace Drupal\tencentcloud_captcha\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\tencentcloud_captcha\UsageDataReport;
/**
 * Configure Tencentcloud Captcha settings.
 */
class TencentcloudCaptchaSettingsForm extends ConfigFormBase
{

  /**
   * {@inheritdoc}
   */
  public function getFormId()
  {
    return 'tencentcloud_captcha_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames()
  {
    return ['tencentcloud_captcha.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state)
  {
    $config = $this->config('tencentcloud_captcha.settings');

    module_load_include('inc', 'captcha');

    $form['general'] = [
      '#type' => 'details',
      '#title' => '基础设置',
      '#open' => true,
      '#attached' => array(
        'library' => array(
          'tencentcloud_captcha/hide_secret',
        ),
      ),
    ];

    $form['general']['tc_secret_id'] = [
      '#description' => '访问 <a target="_blank" href=":url">密钥管理</a>获取SecretId和SecretKey或通过"新建密钥"创建密钥串.',
      '#maxlength' => 40,
      '#required' => true,
      '#title' => 'Secret Id',
      '#type' => 'password',
      '#attributes'=> array(
        'value'=>$config->get('secret_id'),
      )
    ];

    $form['general']['tc_secret_key'] = [
      '#description' => '访问 <a target="_blank" href="https://console.qcloud.com/cam/capi">密钥管理</a>获取SecretId和SecretKey或通过"新建密钥"创建密钥串.',
      '#maxlength' => 40,
      '#required' => true,
      '#title' => 'Secret key',
      '#type' => 'password',
      '#attributes'=> array(
        'value'=>$config->get('secret_key'),
      )
    ];

    $form['general']['tc_app_id'] = [
      '#default_value' => $config->get('app_id'),
      '#description' => '访问 <a target="_blank" href="https://console.cloud.tencent.com/captcha">CaptchaAppId列表</a>获取CaptchaAppId和CaptchaAppSecretKey或通过"新建验证"创建CaptchaAppId.',
      '#maxlength' => 40,
      '#required' => true,
      '#title' => '验证码的App Id',
      '#type' => 'textfield',
    ];

    $form['general']['tc_app_secret_key'] = [
      '#default_value' => $config->get('app_secret_key'),
      '#description' => '访问 <a target="_blank" href="https://console.cloud.tencent.com/captcha">CaptchaAppId列表</a>获取CaptchaAppId和CaptchaAppSecretKey或通过"新建验证"创建CaptchaAppId.',
      '#maxlength' => 40,
      '#required' => true,
      '#title' => '验证码的App Key',
      '#type' => 'textfield',
    ];

    $form['captcha_point'] = [
      '#type' => 'details',
      '#title' => '启用场景',
      '#open' => true,
    ];

    $form['captcha_point']['user_login_form'] = [
      '#type' => 'checkbox',
      '#title' => '登录',
      '#default_value' => captcha_get_form_id_setting('user_login_form')->status(),
    ];
    $form['captcha_point']['user_register_form'] = [
      '#type' => 'checkbox',
      '#title' => '注册',
      '#default_value' => captcha_get_form_id_setting('user_register_form')->status(),
    ];
    $form['captcha_point']['user_pass'] = [
      '#type' => 'checkbox',
      '#title' => '忘记密码',
      '#default_value' => captcha_get_form_id_setting('user_pass')->status(),
    ];
    $form['captcha_point']['node_article_form'] = [
      '#type' => 'checkbox',
      '#title' => '发布文章',
      '#default_value' => captcha_get_form_id_setting('node_article_form')->status(),
    ];
    $form['captcha_point']['comment_comment_form'] = [
      '#type' => 'checkbox',
      '#title' => '发表评论',
      '#default_value' => captcha_get_form_id_setting('comment_comment_form')->status(),
    ];
    $form['custom_filed'] = array(
      '#type' => 'markup',
      '#prefix'=>'<div id="custom_filed">',
      '#suffix'=>'</div>',
      '#markup' => '<a href="https://openapp.qq.com/docs/Drupal/sms.html" target="_blank">文档中心</a> | <a href="https://github.com/Tencent-Cloud-Plugins/tencentcloud-drupal-plugin-sms" target="_blank">GitHub</a> | <a
                    href="https://support.qq.com/product/164613" target="_blank">意见反馈</a>',
      '#tree' => true,
      '#attributes'=>[
        'class'=> array(
          'custom_filed'
        )
      ],
      '#attached' => array(
        'library' => array(
          'tencentcloud_captcha/custom_filed',
        ),
      ),
      '#weight' => 105,
    );
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    module_load_include('inc', 'captcha');
    $secret_id = $form_state->getValue('tc_secret_id');
    $secret_key = $form_state->getValue('tc_secret_key');
    $app_id = $form_state->getValue('tc_app_id');
    $app_secret_key = $form_state->getValue('tc_app_secret_key');
    $config = $this->config('tencentcloud_captcha.settings');
    $config
      ->set('secret_id', $secret_id)
      ->set('secret_key', $secret_key)
      ->set('app_id', $app_id)
      ->set('app_secret_key', $app_secret_key)
      ->save();
    parent::submitForm($form, $form_state);

    $user_login_form = captcha_get_form_id_setting('user_login_form');
    $user_login_form->setCaptchaType('tencentcloud_captcha/tencentcloud_captcha');
    $user_login_form->setStatus($form_state->getValue('user_login_form'))->save();

    $user_register_form = captcha_get_form_id_setting('user_register_form');
    $user_register_form->setCaptchaType('tencentcloud_captcha/tencentcloud_captcha');
    $user_register_form->setStatus($form_state->getValue('user_register_form'))->save();

    $user_pass = captcha_get_form_id_setting('user_pass');
    $user_pass->setCaptchaType('tencentcloud_captcha/tencentcloud_captcha');
    $user_pass->setStatus($form_state->getValue('user_pass'))->save();


    $node_article_form = captcha_get_form_id_setting('node_article_form');
    $node_article_form->setCaptchaType('tencentcloud_captcha/tencentcloud_captcha');
    $node_article_form->setStatus($form_state->getValue('node_article_form'))->save();

    $comment_comment_form = captcha_get_form_id_setting('comment_comment_form');
    $comment_comment_form->setCaptchaType('tencentcloud_captcha/tencentcloud_captcha');
    $comment_comment_form->setStatus($form_state->getValue('comment_comment_form'))->save();

    $host = \Drupal::request()->getSchemeAndHttpHost();
    $uuid = substr(md5(\Drupal::config('system.site')->get('uuid')), 8, 16);
    $data = [
      'action' => 'save_config',
      'plugin_type' => 'captcha',
      'data' => [
        'site_id' => 'drupal_' . $uuid,
        'site_url' => $host,
        'site_app' => 'Drupal',
        'cust_sec_on' => 1,
        'others' => \json_encode([
          'captcha_appid' => $app_id,
          'captcha_appid_pwd' => $app_secret_key,
        ])
      ]
    ];
    (new UsageDataReport($secret_id, $secret_key))->report($data);
  }
}
