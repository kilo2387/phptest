<?php
/**
 * Created by PhpStorm.
 * User: kilo
 * Date: 2017/3/23
 * Time: 1:16
 */
/*四种标量类型：boolean（布尔型）
             integer（整型）
             float（浮点型，也称作 double)
             string（字符串）
  三种复合类型：
             array（数组）
             object（对象）
             callable（可调用）
  最后是两种特殊类型：
             resource（资源）
             NULL（无类型）
*/
echo gettype('string').'<br>';
echo gettype([]).'<br>';
echo gettype(PHP_INT_MAX+1).'<br>';//超出integer最大范围就是一个double
echo gettype(new DateTime()).'<br>';
echo gettype(null).'<br>';

$foo = (float)46;
/* settype($foo, "float"); //boolean integer (float double) string array object null */
echo gettype($foo);

echo is_array([]);
echo is_integer(46);
echo is_int(4635354354);
//is_string();
//is_bool();
//is_dir();
//is_double();
//is_executable();
//is_file();
echo is_long(467979746);

// 绝不要将未知的分数强制转换为 integer，这样有时会导致不可预料的结果。
echo (int) ( (0.1+0.7) * 10 ); // 显示 7!

$ljl =  <<<'EOT'
My name is "$name". I am printing some $foo->foo.
Now, I am printing some {$foo->bar[1]}.
This should not print a capital 'A': \x41
EOT;
echo $ljl;

$great = 'fantastic';
echo "This is ${great}";
