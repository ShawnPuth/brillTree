<h3 align="center">PHP系统树图</h3>

<p align="center">
<a href="https://github.com/ydtg1993/dendrogram"><img src="https://img.shields.io/badge/dendrogram-v1.0-orange.svg" alt="v1.0"></a>
<a href="https://github.com/ydtg1993/dendrogram"><img src="https://img.shields.io/badge/laravel-5.*-yellow.svg" alt="laravel 5.*"></a>
<a href="https://github.com/ydtg1993/dendrogram"><img src="https://img.shields.io/badge/PHP-%3E%3D5.6-blue.svg" alt="PHP>=5.6"></a>
</p>

<table><thead><tr><th style="text-align:center;">dendrogram</th>
<th style="text-align:left;">Laravel</th>
<th style="text-align:left;">PHP</th>
</tr></thead><tbody><tr><td style="text-align:left;">v1.0</td>
<td style="text-align:left;">5.*</td>
<td style="text-align:left;">&gt;=5.6.4</td>
</tr></tbody></table>

### 安装
    composer require dendrogram/dendrogram:v1.0

### 配置
首先往Laravel应用中注册ServiceProvider，打开文件config/app.php，在providers中添加一项：

    'providers' => [
        DenDroGram\DendrogramServiceProvider::class
    ]
    
然后发布拓展包的配置文件，使用如下命令：

    php artisan vendor:publish
    
此时config目录下会生成dendrogram.php配置文件

![config](https://github.com/ydtg1993/dendrogram/blob/master/image/config.PNG)

### 数据导入（两表三个自定义函数 表结构可自行添加字段）
    
    php artisan migrate

adjacency结构 以父节点为基准的链式查询 增删容易 查询不便

![config](https://github.com/ydtg1993/dendrogram/blob/master/image/adjacency.PNG)

nested结构 以左右值包容形式 增删不便 查询容易

![config](https://github.com/ydtg1993/dendrogram/blob/master/image/nested.PNG)

### 举个栗子

![example](https://github.com/ydtg1993/dendrogram/blob/master/image/example.PNG)

adjacency数据结构生成的视图

![example](https://github.com/ydtg1993/dendrogram/blob/master/image/catelog.PNG)

nested数据结构生成的视图

![example](https://github.com/ydtg1993/dendrogram/blob/master/image/rhizome.PNG)

