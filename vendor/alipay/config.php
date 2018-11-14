<?php
$config = array (	
		//应用ID,您的APPID。
		'app_id' => "2016091800538400",

		//商户私钥
		'merchant_private_key' => "MIIEowIBAAKCAQEAzUwPpCnESGA6h1qFBQZ6P7sWIje3Ltgk/uLN/qmtEFN/Q+wteXyG/2IJNG37q6L0k6bZ8SGhGLn/BmQWQDpz+1LRNfC9vX6RSHhKRU+7T9B3OiDThU9l9awMt7aV+49GJcJ6iwvD4cND7x5QunkmqanJ/Y24w4J7hCSnnI+cDUOxRcWifUIvwotmODejgqIR0NG1AR/Xv12lwWXxm6ilD8WU8mcDjfjM6luf/MfdRZx1KGM6UhDaezfjhgbsPVGGRLsLWK2i1lbWCEy787OYwZlnAWC7Y9OB8Nnoz07HThSSJomjbI7gReG4O2yP0AtVPqxG4PC4K/cAG7mvmkSOiQIDAQABAoIBADhl8NYUc0u+w9VzVJ+wy9y+NLJpw/Umg+NRw212h4i4p3mtZEC/qQZ3lDfHDyBzv+TgLXdE2dDFJ/5FeKdkZ4BfnAHJhRaNsrPJ9/1ajga7KkXZxsIUsdnvzf6aNlHJZmfxKWERdlqLHhqOpXbU2X46mrcBPATZz7zZpQIpoaEyvQSy55OY4LyMtUxfHZhej+e3G1qbT3jtnbaYqVOiWjUpHfD0u/z7ASJt1rZgL/nseSMHjQ7LPPkhYC0kTfCoSBEhHtdJw1Sxn8fW2Jl+lyJT3+umEa0M873eO3u2gAppwZ8o5grim4Q5NWpkmmewcnhiZBufLzp2FxfDyicSGUECgYEA+szBgBf56vuJPOy/f/LuNQPaTs/H5OCuBhsqgn9LrcPNUiNi6juNP35EDD5wodwP8ZOY0VQJRigox4YFrLFofJbBIAtXhl30cyOKHIb2fTBFPIR94+P8jcgyDD2zGseJtbsqpdMDE5esI015JIUG7B3+a1HOA2GOC/ogJ1TKBq0CgYEA0Y3G7n0p8umDBEDFSsGjQDAdoh2u8JdnlKtRN/5WSQjsGitm4SkkbVLaiF1/AxMlwIC0HQd3g+HI9l54MIR8HAfS5wfTM6QNPF4YyLZKjMuViqwfOby3fWsAkb+036TyF0X3r66x31o/6PD+U/g4w1JR4briKwNTCMA+VRlWzs0CgYBQZuf5urYCIRWEFJnn2OeI021fKrl4pJblmjvsjgai9EyUcoe5c9H6cu45xqKxIS1zUtAA+6HlfeZk4JBdJprKpkHPlhM/HkvJxbD3KEVJKPppRkhdkK9cfLuetQEAKsv5GMG5W4Z2937V6nZVwNfRRmRT32veJZ42NL+uHD6QGQKBgGcMdVsqKcrOkiMxRtPwTTtvbeMe/bxKeCFf7dy/MedQf+qOlVT8SnGIYPbWI3N7owD7SZdM6LTt/0lIQ4p4XB/cqRX7fxzR+8BH9aAeJKMAKlW7Ns/JweHnEKybvXKNRo+zVI4MNmRDmVIP0MGyOxeyD5oVsMq+I8MV5pEqmMmxAoGBAKbHF0MOOyv9S2aPiFm5F5jxB5SvAKsWKs+jEC4i6FH49VscEdBwDYNquuJVH8rUAtBJsluTH5dUnjagnXEvk+gR6DNXE89TKyyr5oBi1Kx405oM0oqld2j1WRWQq0NFMIci3PX8h/PMWhhnKBIMNUnkI16DpH+CN+tiTBOuz0ID",
		
		//异步通知地址
		'notify_url' => "www.rxg.com",
		
		//同步跳转
		'return_url' => "www.rxg.com",

		//编码格式
		'charset' => "UTF-8",

		//签名方式
		'sign_type'=>"RSA2",

		//支付宝网关
		'gatewayUrl' => "https://openapi.alipay.com/gateway.do",

		//支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
		'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA3gyIVaoxsbj8A9/S6uyzV3rgdeCLz4D676PT9N3NMpAsArmuydUFrYv5pQejlrXfABwuZ+nWu++Ft5M8wW16X7Lhm+aXR+Sg4ZVjIwzAco7h9j2zfOAalyNJ1d9CrI6ggHhVDs4NI4qjko55tt5mQhcQgx0qGNYYpnBcutmQuuUwlJFAn/I8JxOCNGLiisIOF8Z0+s4JN+DGqkuuVrLg/DtVn0NEDfdetuHWFlEGN+uC/JNjFrzT80xGoL67u1xdTXPymxitFXVZQC+s5AUVQg3Jspw1yV4POJZNTsObDwBclcvx6Vn4ED7yv4sKVc23JdboJsReXFLlJXOkRIeZLwIDAQAB",
);