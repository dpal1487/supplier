<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;
use App\Models\Testimonials;

class IndexController extends Controller
{
	private $data;
	public function sliders()
	{
		$sliders = Slider::with('image')->orderBy('order_by', 'asc')->get();
		foreach ($sliders as $slider) {
			$this->data[] = array('slider' => $slider);
		}
		return response()->json(['data' => $this->data]);
	}
	public function testimonials()
	{
		$testimonials = Testimonials::all();
		foreach ($testimonials as $testimonial) {
			$this->data[] = array(
				'id' => $testimonial->id,
				'name' => $testimonial->name,
				'testimonial' => $testimonial->testimonial,
			);
		}
		return response()->json(['data' => $this->data]);
	}
	public function contactUs()
	{
		return response()->json(['success' => true, 'message' => 'Thank you for submiting your details. We will get back to you']);
	}
}
