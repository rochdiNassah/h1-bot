<?php declare(strict_types=1);

namespace Automation\Framework\View;

use Automation\Framework\Application;
use Automation\Framework\Facades\Filesystem;
use Automation\Framework\Facades\View as ViewFacade;

class View
{
    private string $content;

    private string $parent;

    private string $child;

    private bool $is_extending = false;

    private string $title;

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
            throw new ViewNotFoundHttpException($this->view);
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

        $this->view = $this->parent;

        $this->is_extending = false;
        $this->include = false;

        $this->render();
    }

    public function extends(string $view): self
    {
        $this->is_extending = true;

        $this->parent = $view;

        return $this;
    }

    public function child(): string
    {
        return $this->child;
    }

    public function include(string $view, array $data = []): string
    {
        return ViewFactory::make($view, $data);
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }
}