# 腾讯云验证码插件

## 1.插件介绍

> tencentcloud_captcha插件是一款腾讯云研发的，提供给Drupal站长使用的官方插件。实现网站注册、评论、登录、找回密码模块的验证码验证，防止机注册、垃圾评论及垃圾邮件。

| 标题       | 名称                                                         |
| ---------- | ------------------------------------------------------------ |
| 中文名称   | 腾讯云验证码（CAPTCHA）插件                                  |
| 英文名称   | tencentcloud_captcha                                         |
| 最新版本   | v1.0.0 (2020.10.16)                                          |
| 适用平台   | [Drupal](https://www.drupal.org/)                          |
| 适用产品   | [腾讯云验证码](https://cloud.tencent.com/document/product/1110/36334) |
| GitHub项目 | [tencentcloud-drupal-plugin-captcha](https://github.com/Tencent-Cloud-Plugins/tencentcloud-drupal-plugin-captcha) |
| 主创团队   | 腾讯云中小企业产品中心（SMB Product Center of Tencent Cloud） |



## 2.功能特性

- 支持在注册表单中增加验证码

- 支持登录表单增加验证码

- 支持找回密码表单增加验证码

- 支持用户自定义业务场景
  

## 3.安装指引

### 3.1.部署方式一：通过GitHub部署安装

> 1. git clone https://github.com/Tencent-Cloud-Plugins/tencentcloud-drupal-plugin-captcha
> 2. 复制tencentcloud_captcha 文件夹 到Drupal安装路径/modules/文件夹里面
> 3. 下载安装[验证码依赖](https://www.drupal.org/project/captcha)


## 4.使用指引

### 4.1. 页面功能介绍

![](./images/captcha1.png)

> 插件配置页面，需要配置插件的相关信息及勾选需要开启的场景。

![](./images/captcha2.png)

> 登录页面开启验证码效果。



### 4.2. 名词解释

- **自定义密钥**：插件提供统一密钥管理，在多个腾讯云插件时可以共享SecretId和SecretKey，支持各插件自定义密钥。
- **SecretId**：在腾讯云云平台API密钥上申请的标识身份的 SecretId,用于身份验证。详情参考[腾讯云文档](https://cloud.tencent.com/document/product)。
- **SecretKey**：在腾讯云云平台API密钥上申请的标识身份的SecretId对应的SecretKey，用于身份验证。详情参考[腾讯云文档](https://cloud.tencent.com/document/product)。
- **CaptchaAppId**： 在腾讯云短信验证码控制台应用的应用ID，该应用ID默认应用全部场景。详情参考[腾讯云文档](https://cloud.tencent.com/document/product)。
- **CaptchaAppSecretKey**： 在腾讯云短信验证码控制台应用的密钥，需和应用ID匹配。详情参考[腾讯云文档](https://cloud.tencent.com/document/product)。
- **验证码启用场景**：配置腾讯云验证码在WordPress站点中登录、评论、注册、找回密码场景中开启。
- **启用场景**： 腾讯云短信验证码提供四种业务场景，用户可根据Drupal验证场景自由开启腾讯云验证码场景。



## 5.获取入口

| 插件入口          | 链接                                                         |
| ----------------- | ------------------------------------------------------------ |
| GitHub            | [link](https://github.com/Tencent-Cloud-Plugins/tencentcloud-drupal-plugin-captcha) |

## 6.FAQ



## 7.GitHub版本迭代记录

### 7.1 tencentcloud-drupal-plugin-captcha v1.0.0

- 支持在注册表单中增加验证码  
- 支持登录表单增加验证码
- 支持找回密码表单增加验证码
- 支持用户自定义业务场景
---

本项目由腾讯云中小企业产品中心建设和维护，了解与该插件使用相关的更多信息，请访问[春雨文档中心](https://openapp.qq.com/docs/Drupal/captcha.html) 

请通过[咨询建议](https://support.qq.com/products/164613) 向我们提交宝贵意见。