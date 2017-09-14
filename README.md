# Kdyby/Doctrine extensions for PHPStan

* [PHPStan](https://github.com/phpstan/phpstan)
* [Kdyby/Doctrine](https://github.com/Kdyby/Doctrine)

## Usage

This extension is under development and haven't been publish yet.
You can install and use it on your own risk. 
To do so, add it manually into your `consposer.json`:


```json
{
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/vhenzl/phpstan-kdyby-doctrine"
        }
    ],
    "require-dev": {
        "vhenzl/phpstan-kdyby-doctrine": "dev-master"
    }
}
```

And include extension.neon in your project's PHPStan config:

```
includes:
	- vendor/vhenzl/phpstan-kdyby-doctrine/extension.neon
```
