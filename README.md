# Laravel5 多个Auth实现  [![License](https://poser.pugx.org/ollieread/multiauth/license.png)](https://packagist.org/packages/ollieread/multiauth)
###参考 https://github.com/ollieread/multiauth 写的4.2版思路


##使用步骤
> * 替换app.config 中的'Illuminate\Auth\AuthServiceProvider'  为 'Hacklee\Multiauth\XhAuthServiceProvider'
> * 更改auth.php 

配置示例:
```php
<?php
return [ 
		'cp' => [ 
				'driver' => 'cp',
				
				'model' => 'App\CpUser',
				
				'table' => 'cp_user',
				
				'password' => [ 
						'email' => 'emails.password',
						'table' => 'password_resets',
						'expire' => 60 
				] 
		],
		'op' => [ 
				'driver' => 'op',
				
				'model' => 'App\OpUser',
				
				'table' => 'op_user',
				
				'password' => [ 
						'email' => 'emails.password',
						'table' => 'password_resets',
						'expire' => 60 
				] 
		],
		'api' => [ 
				'driver' => 'api',
				
				'model' => 'App\ApiUser',
				
				'table' => 'api_user',
				
				'password' => [ 
						'email' => 'emails.password',
						'table' => 'password_resets',
						'expire' => 60 
				] 
		] 
];
```
##使用示例

```php
Auth::cp()->attempt();
Auth::api()->attempt();
Auth::op()->attempt();
```


