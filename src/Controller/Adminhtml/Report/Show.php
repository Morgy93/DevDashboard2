<?php
namespace Firegento\DevDashboard\Controller\Adminhtml\Report;

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem\Io\File;

class Show extends \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE = 'Firegento_DevDashboard::devdashboard';

    /**
     * @var DirectoryList
     */
    private DirectoryList $directoryList;
    /**
     * @var File
     */
    private File $file;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        DirectoryList $directoryList,
        File $file
    ) {
        $this->directoryList = $directoryList;
        $this->file = $file;
        parent::__construct($context);
    }

    public function execute()
    {
        $report = $this->getRequest()->getParam('text');
        if (!ctype_alnum($report)) {
            throw new \RuntimeException('report id must only contain alphanumeric parameters. given: ' . $report);
        }
        $reportDir = $this->directoryList->getPath(DirectoryList::VAR_DIR) . '/report';
        $reportFile = $reportDir . '/' . $report;

        if (!$this->file->fileExists($reportFile)) {
            throw new \RuntimeException('file not found');
        }
        $reportContents = $this->file->read($reportFile);

        $result = $this->resultFactory->create(ResultFactory::TYPE_RAW);
        $result->setContents($reportContents);
        return $result;
    }
}
