<?php


namespace aivanov\composer;

use Composer\Package\PackageInterface;
use Composer\Installer\LibraryInstaller;

class ModuleInstaller extends LibraryInstaller
{
    const MODULE_PREFIX = 'aivanov-module';

    protected $installPath = "modules";

    public function getInstallPath(PackageInterface $package)
    {
        $prefix = static::MODULE_PREFIX;

        $givenPrefix = substr($package->getPrettyName(), 0, strlen($prefix));

        if ($givenPrefix !== ($prefix . '-')) {
            throw new \InvalidArgumentException("Module names must be prefixed with {$prefix}-");
        }

        return $this->installPath . DIRECTORY_SEPARATOR . substr($package->getPrettyName(), strlen($prefix) + 1);
    }

    /**
     * @param $packageType
     * @return bool
     */
    public function supports($packageType)
    {
        return $packageType === static::MODULE_PREFIX;
    }
}