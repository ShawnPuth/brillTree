<h3 align="center">PHP系统树图</h3>

<table><thead><tr><th style="text-align:left;">dendrogram</th>
<th style="text-align:left;">Laravel</th>
<th style="text-align:left;">PHP</th>
</tr></thead><tbody><tr><td style="text-align:left;">1.0.0</td>
<td style="text-align:left;">5.3.*</td>
<td style="text-align:left;">&gt;=5.6.4</td>
</tr></tbody></table>

### 安装
    composer require dendrogram/dendrogram:v1.0

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

![config](https://github.com/ydtg1993/dendrogram/blob/master/image/config.PNG)

### 数据导入（两表三个自定义函数）
    
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

