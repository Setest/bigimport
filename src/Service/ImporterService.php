<?php

namespace App\Service;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Console\Output\OutputInterface;
use \JsonCollectionParser\Parser;

final class ImporterService
{
  private string $categoriesFile;
//  private string $productsFile;

  public function __construct(
    CategoryService $categoryService,
    ProductService  $productService
  )
  {
    $this->categoryService = $categoryService;
    $this->productService = $productService;
  }

  public function setOutput(OutputInterface $output): void
  {
    $this->output = $output;
  }

  public function initialize(string $categoriesFile, string $productsFile): void
  {
    $this->categoriesFile = $categoriesFile;
    $this->productsFile = $productsFile;
    $this->parser = new Parser();
  }

  public function process(): void
  {
    $this->output->writeln('Import in progress');

    $this->parser->parse($this->categoriesFile, [$this->categoryService, 'import']);
    if ($this->categoryService->hasErrors()){
      $this->output->writeln('There are errors in some records: ' . var_export($this->categoryService->getErrors(), 1));
    }

    $this->output->writeln(sprintf('File "%s" imported', $this->categoriesFile));

    $this->parser->parse($this->productsFile, [$this->productService, 'import']);

    if ($this->productService->hasErrors()){
      $this->output->writeln('There are errors in some records: ' . var_export($this->productService->getErrors(), 1));
    }

    $this->output->writeln(sprintf('File "%s" imported', $this->productsFile));
  }
}