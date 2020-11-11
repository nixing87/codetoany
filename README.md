# codetoany：一个微信公众号网页授权给任何域名下的url
把从微信网页授权接口中获取到的授权code以get参数的形式传递给任何域名下的url。

## 极速使用
* 假设将网页授权回调域名设置为www.test.com；
* 编辑codetoany/getcode.php，将变量$appId的值修改为自己的微信公众号AppId；
* 将文件夹codetoany中的所有文件部署到http://www.test.com/codetoany/；
* 在微信内或使用微信web开发者工具访问 `http://www.test.com/codetoany/getcode.php?auk=demo1`，顺利的话，页面将跳转到类似这样的url：`http://liang.zone/?abc=123&code=0318PVx00bTFzB1JOny00YMRx008PVxS&state=STATE`；
## 攻略指南
* ?auk=demo1中的auk、demo1以及此时的授权url（即接收授权code的url，最终跳转的url）都是可以自定义的；
* 网页授权接口中的get参数scope和state可以以get参数的形式传递给codetoany/getcode.php，程序会把它们再传递给接口；
* 除了get参数auk外，传递给codetoany/getcode.php的任何get参数都会以get参数的形式再传递给授权url；
* 如果网页授权回调域名使用https协议访问，那么程序需要略微调整才可以正常使用；

## 郑重声明
* 本程序仅供学习研究使用，不得用于非法用途，否则后果自负；
* 对于由本程序导致的一切法律和安全问题，作者不承担任何责任；
