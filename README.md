⚠️需要网络能够访问动漫之家

⚠️图片上传后无法删除

# 特点
图片储存在动漫之家论坛

支持上传大于5MB的图片

支持将图片链接保存在本地

# 使用方法

###### nginx 反代配置
```
    location / {
        proxy_pass http://localhost:8080;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;
    }
```    
### 服务器
安装nginx+php

下载源码，将文件上传到网站目录，访问域名即可！

#### 使用自己的反代域名
修改api/api.php文件第54行为你的反代域名

```$domains = ['改为你的反代域名'];```
###### nginx 配置
```
location /file {
            proxy_pass https://upload-forum.idmzj.com/php;
}
```

