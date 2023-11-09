# git-static-analyzer

A static tool to analyze the history of your **git** repository.

Generated report can be used to spot potential problems in your project

[![CI Status](https://github.com/gbyrka/git-static-analyzer/workflows/CI/badge.svg?branch=master&event=push)](https://github.com/gbyrka/git-static-analyzer/actions) [![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)

## Requirements

- PHP installed locally (supported versions >7.2)
- composer https://getcomposer.org/

## Installation

Running following command should be the only needed thing
```sh
composer install
```

## Usage

basic usage
```sh
php index.php analyse ../path/to/the/analyzed/git/repository/ 
```

usage with parameters
```sh
php index.php analyse --project-name="Project Name" --file-name="outputFileName" ../path/to/the/analyzed/git/repository/ 
```
available parameters:
- project-name
- file-name (default "report")
- contributors-count (default 50)
- files-count (default 20)

The corresponding HTML file will be generated. You can open and check it using your web browser.

### Result interpretation

**Files edited most often** are also read most often. This means we want to keep them in the cleanest shape. Unfortunately, because they are edited most often, they tend to be the dirtiest one. During any code refactoring, you should consider cleaning those files.

**Most active contributors** should be used to spot moments when important team members (all group of developers) left the project. This might result in the lack of knowledge transfer and project inconsistency.

More git analysis could be done with those commands: https://github.com/gbyrka/git-log-analysis

## Contribution

This project is on early stage, however, contribution and all suggestions are welcomed!

If you would like to contribute, please follow our [Code of Conduct](CODE_OF_CONDUCT.md).
