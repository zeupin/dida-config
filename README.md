# Dida\Config 组件库

`Dida\Config` 是一个 App 配置组件，可以方便地对 App 的配置项进行各种高级设置。它是 [宙品科技](http://zeupin.com) 开源的 [Dida 框架](http://dida.zeupin.com) 的一个功能组件。

- Home <https://github.com/zeupin/dida-config>

## API

- `has($key)` -- 检查是否有指定 key 的配置。
- `set($key, $value)` -- 设置一个配置项。
- `get($key, $default = null)` -- 获取指定配置项，如果配置项不存在，返回 default 值。
- `remove($key)` -- 删除一个配置项。
- `keys()` -- 获取所有配置项的 keys。
- `sortKeys()` -- 对配置项按 key 排序。
- `clear()` -- 删除所有配置项。
- `merge(array $confs)` -- 批量合并一个配置项数组。
- `getKeysByGroup($group)` -- 获取指定 group 的所有 keys。
- `getItemsByGroup($group)` -- 获取指定 group 的所有配置项。
- `groupExpand($group, array $items)` --将给出的 items 扩展到指定的 group 上。
- `groupPack($group)` -- 对给出的 group 进行压缩，返回压缩后的配置数组。
- `groupClear($group)` -- 删除指定 group 的所有配置项。
- `load($filepath, $group = null)` -- 从文件中载入配置。

## 说明

1. 一个load()可以读取的配置文件如下：
```php
<?php
return [

];
```

1. `groupExpand()` 和 `groupPack()` 是逆过程：

   ```php
   $confA = [""=>0, "a"=>1, "b"=>2, "c"=>3];

   Config::groupExpand("db", $confA);

   // Config::$items = [
   //   "db" => 0,
   //   "db.a" => 1,
   //   "db.b" => 2,
   //   "db.c" => 3,
   // ]

   $confB = Config::groupPack("db");

   // $confB = [""=>0, "a"=>1, "b"=>2, "c"=>3]
   ```

## 作者

- [Macc Liu](https://github.com/maccliu)，欢迎互动探讨。

## 感谢

- [宙品科技，Zeupin LLC](http://zeupin.com) , 尤其是 [Dida 框架团队](http://dida.zeupin.com)。

## 版权声明

版权所有 (c) 上海宙品信息科技有限公司。<br>Copyright (c) Zeupin LLC. <http://zeupin.com>

源代码采用 MIT 授权协议。<br>Licensed under The MIT License.

如需在您的项目中使用，必须保留本源代码中的完整版权声明。<br>Redistributions of files MUST retain the above copyright notice.
