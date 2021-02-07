<?php

namespace Firegento\DevDashboard\ViewModel\Widget;

use Hyva\Admin\Api\HyvaGridArrayProviderInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem\Io\FileFactory;

class ExceptionReports implements HyvaGridArrayProviderInterface
{
    /**
     * @var DirectoryList
     */
    private DirectoryList $directoryList;
    /**
     * @var FileFactory
     */
    private FileFactory $fileFactory;

    public function __construct(DirectoryList $directoryList, FileFactory $fileFactory)
    {
        $this->directoryList = $directoryList;
        $this->fileFactory = $fileFactory;
    }
    /**
     * @return array<string>
     */
    public function getHyvaGridData(): array
    {
        $file = $this->fileFactory->create();
        $reportDir = $this->directoryList->getPath(DirectoryList::VAR_DIR) . '/report';
        if (! is_dir($reportDir)) {
            return [];
        }
        $file->cd($reportDir);
        return $file->ls();

    }
}
