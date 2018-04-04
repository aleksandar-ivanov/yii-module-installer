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

        $givenPrefix = substr($package->getPrettyName(), strpos($package->getPrettyName(), '/') + 1, strlen($prefix) + 1);

        if ($givenPrefix !== ($prefix . '-')) {
            throw new \InvalidArgumentException("Module names must be prefixed with {$prefix}- ... Found $givenPrefix");
        }

        $packageParts = explode('-',substr($package->getPrettyName(), strpos($package->getPrettyName(), '/') + 1));
        $packageName = implode('-', array_splice($packageParts, 2));

        return $this->installPath . DIRECTORY_SEPARATOR . $packageName;
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