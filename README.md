<h3 align="center">laravel系统树图</h3>

<table><thead><tr><th style="text-align:left;">dendrogram</th>
<th style="text-align:left;">Laravel</th>
<th style="text-align:left;">PHP</th>
</tr></thead><tbody><tr><td style="text-align:left;">1.0.0</td>
<td style="text-align:left;">5.3.*</td>
<td style="text-align:left;">&gt;=5.6.4</td>
</tr></tbody></table>

### 安装
1. composer require dendrogram/dendrogram

### 配置
首先往Laravel应用中注册ServiceProvider，打开文件config/app.php，在providers中添加一项：

    [
    'providers' => [
        DenDroGram\DendrogramServiceProvider::class
      ]
    ]
    
然后发布拓展包的配置文件，使用如下命令：

    php artisan vendor:publish
    
此时config目录下会生成dendrogram.php配置文件   

### 数据导入
    
    php artisan migrate
    
### 实例图    
