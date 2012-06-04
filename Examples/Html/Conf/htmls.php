<?php
return array(
    '*'=>array('{$_SERVER.REQUEST_URI|md5}'),
);
/*
    静态规则的定义有三种方式，
    第一种是定义全局的操作静态规则，例如定义所有的read操作的静态规则为
        'read'=>array('{id}','60') 
        其中，{id} 表示取$_GET['id'] 为静态缓存文件名，第二个参数表示缓存60秒
    第二种是定义全局的模块静态规则，例如定义所有的User模块的静态规则为
        'User:'=>array('User/{:action}_{id}','600') 
        其中，{:action} 表示当前的操作名称
    第三种是定义某个模块的操作的静态规则，例如，我们需要定义Blog模块的read操作进行静态缓存
    'Blog:read'=>array('{id}',-1)
    有个别特殊的规则，例如空模块和空操作的静态规则的定义，可以使用下面的方式：
    'Empty:index'=>array('{:module}_{:action}',-1)  // 定义空模块的静态规则
    'User:_empty'=>array('User/{:action}',-1)  // 定义空操作的静态规则
    第四种方式是定义全局的静态缓存规则，这个属于特殊情况下的使用，任何模块的操作都适用，例如
    '*'=>array('{$_SERVER.REQUEST_URI|md5}'), 根据当前的URL进行缓存
    静态规则的写法可以包括以下情况
    1、使用系统变量 包括 _GET _REQUEST _SERVER _SESSION _COOKIE
    格式：{$_×××|function}
    例如：{$_GET.name} {$_SERVER. REQUEST_URI}
    2、使用框架特定的变量
    例如：{:app}、{:group} 、{:module} 和{:action} 分别表示当前项目名、分组名、模块名和操作名
    3、使用_GET变量
    {var|function}      
    也就是说 {id} 其实等效于 {$_GET.id}
    4、直接使用函数
    {|function}           
    例如：{|time}
    5、支持混合定义，例如我们可以定义一个静态规则为：
    '{id},{name|md5}' 
    在{}之外的字符作为字符串对待，如果包含有”/”，会自动创建目录。
    例如，定义下面的静态规则：
    {:module}/{:action}_{id}
    则会在静态目录下面创建模块名称的子目录，然后写入操作名_id.shtml 文件。
 */
?>