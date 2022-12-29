# Laravel Uploader with ready api endpoint
[![Latest Stable Version](http://poser.pugx.org/ibekzod/uploader/v)](https://packagist.org/packages/ibekzod/uploader) [![Total Downloads](http://poser.pugx.org/ibekzod/uploader/downloads)](https://packagist.org/packages/ibekzod/uploader) [![Latest Unstable Version](http://poser.pugx.org/ibekzod/uploader/v/unstable)](https://packagist.org/packages/ibekzod/uploader) [![License](http://poser.pugx.org/ibekzod/uploader/license)](https://packagist.org/packages/ibekzod/uploader) [![PHP Version Require](http://poser.pugx.org/ibekzod/uploader/require/php)](https://packagist.org/packages/ibekzod/uploader)

This is file uploader lightweight package with upload service and ready made api with controllers 

## Installation

You can install the package via composer:

```bash
composer require ibekzod/uploader
```
Publish the config file (config/mediable.php) of the package using artisan.
```bash
php artisan vendor:publish --provider="IBekzod\Uploader\UploaderServiceProvider"
```
Run the migrations to add the required tables to your database.
```bash
php artisan migrate
```
## Usage
Upload a file to the server, and place it in a directory on the filesystem disk named "uploads" with subdirectory "files" or your custom referring type
```php
<?php
    use IBekzod\Uploader\Uploader;
    use IBekzod\Uploader\Models\Upload;
    use App\Models\Post;

    $upload = Uploader::uploadAttachment($request->file('attachment'))->getUpload();
    //Let's assume we have Post model with image_id column or file_id whatever name you can write
    $post = Post::create([
        'title'=>'Title',
        'body'=>'Body',
        'image_id'=>$upload->id //unsigned big integer is preferred
    ]);
    //This is optional if you want to find 
    $upload->relation='post';//or simply Post::class
    $upload->relation_id=$post->id;
    $upload->save();
    //By this way you can get all post images
    $allPostImages=Upload::where('relation', 'post')->get();
    //Or related first post image
    $postImage=Upload::where('relation', 'post')->where('relation_id', $post->id)->first();
    //You are free to design your structure by using Upload
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email erkinovbegzod.45@gmail.com instead of using the issue tracker.

## Credits

-   [Bekzod Erkinov](https://github.com/ibekzod)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

