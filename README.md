# git-static-analyzer

A static tool to analyze the history of your **git** repository. 

Generated report can be used to spot potential problems in your project

[![CI Status](https://github.com/gbyrka-fingo/git-static-analyzer/workflows/CI/badge.svg?branch=master&event=push)](https://github.com/gbyrka-fingo/git-static-analyzer/actions) [![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)

## Requirements

- PHP installed locally (supported versions ^7.2)

## Download

Go to the [releases page](https://github.com/skrajewski/git-static-analyzer/releases) and download the newest version.

You can also build this tool manually. See [Contribution](#contribution) for more details.

## Usage

```bash
gsa.phar analyse /path/to/the/root/of/repository
```

You can also provide options to customize the output:

```bash
gsa.phar analyse /path/to/the/root/of/repository \
  --filename=report-2020-04-04 \
  --project-name=InternalProject \
  --files-count=50 \
  --contributors-count=30
```

The corresponding HTML file will be generated. You can open and check it using your web browser.

### Result interpretation

**Files edited most often** are also read most often. This means we want to keep them in the cleanest shape. Unfortunately, because they are edited most often, they tend to be the dirtiest one. During any code refactoring, you should consider cleaning those files.

**Most active contributors** should be used to spot moments when important team members (all group of developers) left the project. This might result in the lack of knowledge transfer and project inconsistency.

More git analysis could be done with those commands: https://github.com/gbyrka-fingo/git-log-analysis

## Contribution

This project is on early stage, however, contribution and all suggestions are welcomed!

If you would like to contribute, please follow our [Code of Conduct](CODE_OF_CONDUCT.md).

### Installation

1. Fork or clone this repository
2. Install all dependencies using `composer update`

The `index.php` file is the entry point to the application. 

### Creating a PHAR

This package uses [humbug/box](https://github.com/humbug/box) to create a PHAR bundle. You need to install this tool on your local machine. Configuration is provided in `box.json` file. 

To compile a bundle, run `composer run build`.
