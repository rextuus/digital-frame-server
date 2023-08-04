<?php

declare(strict_types=1);

namespace App\Service;

use Cloudinary\Api\Exception\ApiError;
use Cloudinary\Cloudinary;
use Cloudinary\Configuration\Configuration;

/**
 * @author  Wolfgang Hinzmann <wolfgang.hinzmann@doccheck.com>
 * @license 2023 DocCheck Community GmbH
 */
class CloudinaryApiGateway
{

    private Cloudinary $cloudinary;

    public function __construct() {
        $config = new Configuration();
        $config->cloud->cloudName = 'dl4y4cfvs';
        $config->cloud->apiKey = '311921677578484';
        $config->cloud->apiSecret = 'X6oJvCzY4tIBcWstDA2YPUfukmQ';
        $config->url->secure = true;
        $this->cloudinary = new Cloudinary($config);
    }

    public function test(){
        $this->cloudinary->uploadApi()->upload(
            'https://upload.wikimedia.org/wikipedia/commons/a/ae/Olympic_flag.jpg',
            ['public_id' => 'olympic_flag']
        );
    }

    public function uploadImage(string $image): bool
    {
        try {
            $public_id = 'digital-frame/test';
            $this->cloudinary->uploadApi()->upload(
                $image,
                [
                    'public_id' => $public_id,
                ]
            );
        } catch (ApiError $e) {
            return false;
        }

        return true;
    }
}