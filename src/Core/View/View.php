<?php declare(strict_types=1);

namespace Automation\Core\View;

use Automation\Core\Application;
use Automation\Core\Facades\Filesystem;
use Automation\Core\Facades\View as ViewFacade;

class View
{
    private string $content;

    private string $child;

    private bool $is_extending = false;

    private string $parent;

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

    /** [TODO] Must be refactored! */
    public function render(): void
    {
        Filesystem::update_root('views');

        $view_path = Filesystem::to(sprintf('%s.php', $this->view));

        if (Filesystem::missing($view_path)) {
            throw new ViewNotFoundException($this->view);
        }

        Filesystem::reset_root();

        $this->app->bind('view', $this);

        extract($this->data);

        ob_start();

        require $view_path;

        if (!$this->is_extending) {
            $this->content = ob_get_clean();

            return;
        }

        $this->child = ob_get_clean();

        Filesystem::update_root('views');

        $parent_view_path = Filesystem::to(sprintf('%s.php', $this->parent));

        if (Filesystem::missing($parent_view_path)) {
            throw new ViewNotFoundException($this->parent);
        }

        Filesystem::reset_root();

        ob_start();

        require $parent_view_path;

        $this->content = ob_get_clean();
    }

    public function extends(string $view): void
    {
        $this->is_extending = true;

        $this->parent = $view;
    }

    public function child(): string
    {
        return $this->child;
    }
}