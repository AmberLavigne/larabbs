<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests\Api\VerificationCodeRequest;

class VerificationCodesController extends Controller
{
    #发送短信验证码接口
    public function store(VerificationCodeRequest $request){

        $captchaData = \Cache::get($request->captcha_key);
        if(!$captchaData){
            return $this->response->error('图片验证码已失效',422);
        }
        if(!hash_equals($request->captcha_code,$captchaData['code'])){
            \Cache::forget($request->captcha_key);
            return $this->response->errorUnauthorized('验证码错误');
        }

        $phone = $captchaData['phone'];
        if(!app()->environment('production')){
            $code = '11211';
        }else{
            $code = str_pad(random_int(1,9999),4,0,STR_PAD_LEFT);  //   填充

            try{
                $result = true;
            }catch (\GuzzleHttp\Exception\ClientException $exception){
                $response = $exception->getResponse();
                $result = json_decode($response->getBody()->getContents(), true);
                return $this->response->errorInternal($result['msg'] ?? '短信发送异常');

            }
        }

        $key = 'verificationCode_'.str_random(15);
        $expiredAt = now()->addMinutes(10);
        // 缓存验证码 10分钟过期。
        \Cache::put($key,['phone'=>$phone,'code'=>$code],$expiredAt);
        // 清除图片验证码缓存
        \Cache::forget($request->captcha_key);
        return $this->response->array([
            'key' => $key,
            'expired_at'=>$expiredAt->toDateTimeString(),
            ])->setStatusCode(201);
    }
}
