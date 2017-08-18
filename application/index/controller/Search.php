<?php
/**
 * Created by PhpStorm.
 * User: 君行天下
 * Date: 2017/8/18
 * Time: 10:52
 */

namespace app\index\controller;
use think\Controller;

class Search extends Controller
{
    public function index()
    {
        $num=input('m');                                    //获取查询手机号
        $host='http://showphone.market.alicloudapi.com';       //查询主机链接
        $path="/6-1";
        $querys="num=".$num;                                 //查询参数
        $url=$host.$path.'?'.$querys;                           //完整请求链接

        $appcode='030434e4440d422eaa33b91ae5487eea';            //接口app码
        $headers = array();
        array_push($headers, "Authorization:APPCODE " . $appcode);//请求头

        $method='GET';                                               //请求方式

        $curl=curl_init();                                           //初始化一个curl句柄,用于获取其它网站内容
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method); //请求方式
        curl_setopt($curl, CURLOPT_URL, $url);   //请求url
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers); //请求头
        curl_setopt($curl, CURLOPT_FAILONERROR, false);  //是否显示HTTP状态码
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);//执行成功返回结果
        curl_setopt($curl, CURLOPT_HEADER, false);    //是否返回请求头信息
        if (1 == strpos("$".$host, "https://"))
        {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);//禁止curl验证对等证书
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);//不检查证书
        }
        $res=curl_exec($curl);//执行查询句柄
        curl_close($curl);    //关闭查询连接
        $resu=json_decode($res,true);//将json数据解码为php数组4

        if($resu['showapi_res_body']['ret_code']==-1){
            return $this->error('没有查询结果，请重新输入','Index/index');
        }else{
            $this->assign('num',$num);
            $this->assign('res',$resu);
            return $this->fetch('index');
        }
    }
}