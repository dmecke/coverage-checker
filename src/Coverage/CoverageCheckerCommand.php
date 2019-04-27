<?php

declare(strict_types=1);

namespace CoverageChecker\Coverage;

use InvalidArgumentException;
use SimpleXMLElement;
use function sprintf;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;
use function var_dump;

final class CoverageCheckerCommand extends Command
{
    protected function configure(): void
    {
        $this->setName('check');
        $this->addArgument('filename', InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $inputFile = $input->getArgument('filename'); // path to clover xml file

        if (!file_exists($inputFile)) {
            throw new InvalidArgumentException('Invalid input file provided');
        }

        $xml = new SimpleXMLElement(file_get_contents($inputFile));
        $classes = $xml->xpath('//class');

        $config = Yaml::parseFile('coverage-checker.yaml');

        /** @var CoverageCheck[] $coverageChecks */
        $coverageChecks = array_map(static function ($key, $node) {
            return new CoverageCheck(new NamespacePart($key), $node);
        }, array_keys($config['coverage']), $config['coverage']);

        foreach ($classes as $class) {
            $this->checkClass($class, $coverageChecks);
        }

        foreach ($coverageChecks as $coverageCheck) {
            $output->writeln($coverageCheck->report());
        }

        foreach ($coverageChecks as $coverageCheck) {
            if (!$coverageCheck->passes()) {
                return 1;
            }
        }

        return 0;
    }

    /**
     * @param CoverageCheck[] $coverageChecks
     *
     * @return CoverageCheck[]
     */
    private function checkClass(SimpleXMLElement $classElement, array $coverageChecks): array
    {
        $metric = $classElement->metrics;
        $elements = (int) $metric['elements'];
        $coveredElements = (int) $metric['coveredelements'];
        $namespace = (string) $classElement['namespace'];

        $found = [];
        foreach ($coverageChecks as $ns) {
            if ($ns->getNamespacePart()->isPartOf($namespace)) {
                $ns->add($elements, $coveredElements);
            }
        }

        return $found;
    }
}
