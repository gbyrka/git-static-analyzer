# git-static-analyzer

A static tool to analyze the history of your **git** repository. 

Generated report can be used to spot potential problems in your project

[![CI Status](https://github.com/gbyrka-fingo/git-static-analyzer/workflows/CI/badge.svg?branch=master&event=push)](https://github.com/gbyrka-fingo/git-static-analyzer/actions) [![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)

# Requirements

- PHP installed locally (supported versions 5.3 - 7.4)
- composer https://getcomposer.org/

# Instalation

- clone, fork or download this tool
- run
```sh
composer update
```

# Usage
basic usage
```sh
php analyse.php ../path/to/the/analyzed/git/repository/ 
```

usage with parameters
```sh
php analyse.php ../path/to/the/analyzed/git/repository/ --projectName="Project Name"  --fileName="outputFileName"
```
available parameters:
- projectName
- fileName (default "report")
- contributorsCount (default 50)
- filesCount (default 20)

# Result interpretation

**Files edited most often** are also read most often. This means we want to keep them in the cleanest shape. Unfortunately, because they are edited most often, they tend to be the dirtiest one. During any code refactoring, you should consider cleaning those files.

**Most active contributors** should be used to spot moments when important team members (all group of developers) left the project. This might result in the lack of knowledge transfer and project inconsistency.

More git analysis could be done with those commands: https://github.com/gbyrka-fingo/git-log-analysis


