<?php
declare(strict_types=1);

namespace App\Command;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;


final class ImportCommand extends Command
{
  protected static $defaultName = 'import';
  private $container;
  private $basePath;

  /**
   * In this method setup command, description, and its parameters
   */
  protected function configure()
  {
    $this->setHelp('blabalbal')
      ->setDescription('Import data from JSON files')
      ->addArgument('categories', InputArgument::REQUIRED, 'Categories json file')
      ->addArgument('products', InputArgument::REQUIRED, 'Products json file')
      ->addUsage('ddd dddd ddd');
  }

  public function __construct(ContainerBuilder $container, string $basePath) {
    $this->container = $container;
    $this->basePath = $basePath;
    parent::__construct();
  }

  /**
   * Here all logic happens
   */
  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $categoriesFilePath = $input->getArgument('categories');
    $productsFilePath = $input->getArgument('products');

    $this->validate($categoriesFilePath, $productsFilePath);

    $fileLocator = new FileLocator($this->basePath);
    $categoriesFile = $fileLocator->locate($categoriesFilePath);
    $productsFile = $fileLocator->locate($productsFilePath);

    $importerService = $this->container->get('importer.service');
    $importerService->setOutput($output);

    if (empty($importerService)) {
      throw new Exception('Service importer not found!');
    }

    $importerService->initialize($categoriesFile, $productsFile);
    $importerService->process();

    return self::SUCCESS;
  }

  /**
   * @param string $categoriesFilePath
   * @param string $productsFilePath
   */
  protected function validate (string $categoriesFilePath, string $productsFilePath): void
  {
    // check filenames and paths
  }
}