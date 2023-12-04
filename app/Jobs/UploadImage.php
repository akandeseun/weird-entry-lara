<?php

namespace App\Jobs;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class UploadImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */

    protected $product_image;
    // protected $product;
    public function __construct($product_image, public Product $product)
    {
        //
        $this->product_image = $product_image;
        // $this->product = $product;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // $result = $this->path->storeOnCloudinary('products');
        // $url = $result->getSecurePath();

        // $contents = Storage::url($this->path);
        // $contents = file_get_contents($this->path);
        // $img = imagecreatefromstring(base64_decode($contents));
        // $result = $img->storeOnCloudinary('products');
        // $url = $result->getSecurePath();
        // // $this->product->attachMedia($contents);
        // $this->product->product_image = $url;
    }
}
