# third-party

第三方平台介绍
在得到公众号或小程序管理员授权后，基于该平台，第三方服务商可以为公众号代运营、小程序代注册、代开发等服务
参考：https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/2.0/api/Before_Develop/creat_token.html


开发步骤
核心：组装一个授权地址，公众号或小程序管理员打开授权地址,在完成了授权给第三方平台之后，第三方平台则可以获得authorizer_access_token进行调用相关api

Token生成说明
1、配置授权事件URL，用于接收component_verify_ticket
在第三方平台创建审核通过后，微信服务器会向其 ”授权事件接收URL” 每隔 10 分钟以 POST 的方式推送 component_verify_ticket

2、获得component_verify_ticket后，使用component_verify_ticket获取component_access_token（平台TOKEN）

3、获得component_access_token后，使用component_access_token调接口获取pre_auth_code

4、获得pre_auth_code后，使用pre_auth_code拼接授权地址，当公众号/小程序对第三方平台进行授权、取消授权、更新授权后，微信服务器会向第三方平台方的授权事件接收URL 以 POST 的方式推送相关通知。
授权成功后，会得到一个 authorization_code

5、获得authorization_code后，使用authorization_code调接口获取authorizer_access_token和authorizer_refresh_token
    authorizer_access_token 就是最终想要获取的授权TOKEN，使用它就可以代替公众号或小程序调用相关接口
    authorizer_refresh_token authorizer_access_token 有效期为 2 小时，过期后需要使用authorizer_refresh_token刷新authorizer_access_token



