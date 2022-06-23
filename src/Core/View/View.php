<?php declare(strict_types=1);

namespace Automation\Core\View;

use Automation\Core\Application;
use Automation\Core\Facades\Filesystem;

class View
{
    private string $content;

    public function __construct(
        private string $view,
        private array $data,
        private Application $app
    ) {

    }

    public function content(): string
    {
        return $this->content;
    }

    public function render(): void
    {
        Filesystem::update_root('views');

        $view_path = Filesystem::to(sprintf('%s.php', $this->view));

        if (Filesystem::missing($view_path)) {
            throw new ViewNotFoundException($this->view);
        }

        extract($this->data);

        ob_start();

        require $view_path;

        $content = ob_get_clean();

        $this->content = $content;
    }
}