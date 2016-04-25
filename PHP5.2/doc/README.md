##使用

引入validator.php文件即可，例如

    require dirname(__FILE__) . '/validate/validator.php';

1、进行验证
<pre><code>
$input = $_POST;

//规则条件
$rules = array(
    'test_name' => 'required|maxlength;max=3|int',
    'age' => 'maxlength;maxlength=2|required',
    'sex' => 'required'
);

//属性名字(可选)
$labels = array(
    'test_name' => '用户名',
    'sex' => '性别'
);

//错误消息(可选)
$messages = array(
    'test_name.required' => "必须填写用户名",
    'test_name.maxlength' => '用户名长度最大为:maxlength',
);

validator::make($input, $rules, $labels, $messages);
</code></pre>

多个验证添加使用“|”隔离

2、判断验证是否具有错误

    validator::errors()

3、获取第一个错误

    validator::first()

4、获取指定参数错误

    validator::get('test_name')

5、判断某个参数是否具有错误

    validator::has('test_name')


##支持类型

1、整形

    语法：int

2、是否必须

    语法：required

3、最大长度

    语法：maxlength;maxlength=num
    num是数字

4、回调函数

    语法:callback;callback=function
    function是你的执行方法

    如果你的方法是全局的（例如：test），直接书写callback;callback=test
    方法中只能接受两个参数$name,$value

    如果你的方法是类中的方法(例如：example类中的test方法)
    $example = new example();
    callbak;callback=array($example,'test')
    
    function test($name,$value){
        return false;//return ture;
    }

##扩展

你只需要在文件夹template下面新建你的新验证，按照规范命名即可增加新的验证

例如：

`validatorInt` 这是一个整数验证

`class validatorInt {}`