<?php

declare(strict_types=1);

/**
 * Init namespaces autoload.
 */
class autoload
{
    /**
     * All namespaces which need load.
     *
     * @var string[]
     */
    private $namespacesMap = [
        'Framework' => PD . '/lib/Framework',
    ];

    /**
     * Load all not default vendor paths.
     */
    public function __construct()
    {
        $this->addVendorsToNamespacesMap();
    }

    /**
     * Init namespaces autoload.
     * @return void
     */
    public function init(): void
    {
        spl_autoload_register([$this, 'loadClass']);
    }

    /**
     * Require class.
     *
     * @param $class
     * @return bool
     */
    protected function loadClass(string $class): bool
    {
        $pathParts = explode('\\', $class);
        $result = false;

        if (is_array($pathParts)) {
            $namespace = array_shift($pathParts);

            if (!empty($this->namespacesMap[$namespace])) {
                $filePath = $this->namespacesMap[$namespace] . '/' . implode('/', $pathParts) . '.php';
                require_once $filePath;
                $result = true;
            }
        }

        return $result;
    }

    /**
     * Add all vendor namespaces to namespaces map.
     *
     * @return void
     */
    private function addVendorsToNamespacesMap(): void
    {
        $codePath = PD . '/app/code';
        if (false === $this->isAppCodeDirExists($codePath)) {
            return;
        }
        $foundVendorDirs = glob($codePath . '/*');
        if (false !== $foundVendorDirs) {
            foreach ($foundVendorDirs as $vendorDirPath) {
                if (is_dir($vendorDirPath)) {
                    $explodedPath = explode(DS, $vendorDirPath);
                    $reversedPath = array_reverse($explodedPath);
                    $vendorName = array_shift($reversedPath);
                    $this->namespacesMap[$vendorName] = $vendorDirPath;
                }
            }
        }
    }

    /**
     * Return false if folder app/code didn't exist.
     *
     * @param string $dirPath
     * @return bool
     */
    private function isAppCodeDirExists(string $dirPath): bool
    {
        $result = true;

        if (!is_dir($dirPath)) {
            $result = false;
        }

        return $result;
    }
}