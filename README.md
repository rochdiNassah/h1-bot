# What is this?
This is a framework that consists of many ready to use tools and scripts.

### Installation
* Clone this repository.
* Copy `.env.example` to `.env`.
* Adjust environment variables in `.env`.
* Run `composer install`.
* Link `./automation` executable file to your `$_PATH` so it can be located by your system.

### Usage
```automation <command>```

### Usage examples
* ```automation encode "foo"```
* ```automation decode "Zm9v"```
* ```automation encode --help```
* ```automation encode``` This one will prompt you to enter the text or file path that you want to encode.

### Available commands
* `encode` Base64 encode a text or file.
* `decode` Base64 decode a text or file.
