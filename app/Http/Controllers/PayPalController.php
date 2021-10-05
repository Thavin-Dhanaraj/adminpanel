<?php

namespace App\Http\Controllers;

use App\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\ImageUpload;
use Auth;
use App\Logging;
//use Srmklive\PayPal\Services\PayPal as PayPalClient;
//use Srmklive\PayPal\Facades\PayPal;
use Srmklive\PayPal\Services\ExpressCheckout;

class PayPalController extends Controller
{
    public function getExpressCheckout(Request $request)
    {
        $restaurants2 = DB::table('restaurants')->join("image_uploads", 'image_uploads.id', '=', 'restaurants.imageid')->
        select('restaurants.*', 'image_uploads.filename as image')->get();
        echo $restaurants2;

        return ;
        $provider = new ExpressCheckout;
        //$provider = new PayPalClient;
        //$provider = PayPal::setProvider('express_checkout');

        //$response = $provider->setExpressCheckout($checkoutData);
        
//        $provider = PayPal::setProvider('express_checkout');

        $payPalCart = $this->getCheckoutData();

//        $user = $this->userRepository->findByField('api_token', $request->get('api_token'))->first();
//        $coupon = $this->couponRepository->findByField('code', $request->get('coupon_code'))->first();
//        $deliveryId = $request->get('delivery_address_id');
//        if (!empty($user)) {
//            $this->order->user = $user;
//            $this->order->user_id = $user->id;
//            $this->order->delivery_address_id = $deliveryId;
//            $this->coupon = $coupon;
//            $payPalCart = $this->getCheckoutData();
//            try {
        
//                echo $provider;
                $response = $provider->setCurrency('EUR')->setExpressCheckout($payPalCart);
                echo "$response";
//                if (!empty($response['paypal_link'])) {
//                    return redirect($response['paypal_link']);
//                } else {
//                    echo $response['L_LONGMESSAGE0'];
                    //Flash::error($response['L_LONGMESSAGE0']);
//                }
//            } catch (\Exception $e) {
//                echo "error";
//                echo $e->getMessage();
//             //   Flash::error("Error processing PayPal payment for your order :" . $e->getMessage());
//            }
//        }
//        return redirect(route('payments.failed'));
    }

    private function getCheckoutData()
    {
        $data = [];
        //$this->calculateTotal();
        //$order_id = $this->paymentRepository->all()->count() + 1;
        $data['items'][] = [
            'name' => "name",
            'price' => "100",
            'qty' => 1,
        ];
        $data['total'] = "200";
        $data['return_url'] = url("payments/paypal/express-checkout-success?user_id=");
//        $data['return_url'] = url("payments/paypal/express-checkout-success?user_id=" . $this->order->user_id . "&delivery_address_id=" . $this->order->delivery_address_id);
//        $data['return_url'] = url("payments/paypal/express-checkout-success");

//        if (isset($this->coupon)) {
//            $data['return_url'] .= "&coupon_code=" . $this->coupon->code;
//        }
        $data['cancel_url'] = url('payments/paypal');
        $data['invoice_id'] = "s" . '_' . date("Y_m_d_h_i_sa");
        $data['invoice_description'] = "desc";

        //dd($data);
        return $data;
    }


}