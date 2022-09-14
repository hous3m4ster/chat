# Secure websocket nginx router configuration
```
location /socket/ {
        proxy_pass http://127.0.0.1:8090/demo/php-socket.php;
        proxy_http_version 1.1;
        proxy_set_header Upgrade $http_upgrade;
        proxy_set_header Connection "Upgrade";
}
```