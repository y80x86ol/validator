##验证类

一个可以任意扩展的PHP验证类，让验证变得更加简单

##需求

PHP：5.2+

##使用

引入validator.php文件即可，例如

    require dirname(__FILE__) . '/validate/validator.php';

1、进行验证
<pre><code>
$input = $_POST;

$rules = array(
    'test_name' => 'required|maxlength;maxlength=3|int',
    'age' => 'maxlength;maxlength=2|required',
    'sex' => 'required'
);
$labels = array(
    'test_name' => '用户名',
    'sex' => '性别'
);
$messages = array(
    'test_name.required' => "必须填写用户名",
    'test_name.maxlength' => '用户名长度最大为:maxlength',
);

validator::make($input, $rules, $labels, $messages);
</code></pre>

2、判断验证是否具有错误

    validator::errors()

3、获取第一个错误

    validator::first()

4、获取指定参数错误

    validator::get('test_name')

5、判断某个参数是否具有错误

    validator::has('test_name')

##扩展

你只需要在文件夹template下面新建你的新验证，按照规范命名即可增加新的验证

例如：

`validatorInt` 这是一个整数验证

`class validatorInt {}`