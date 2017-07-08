<?php

namespace d0niek\Whereiscash\Http\Response;

use d0niek\Whereiscash\Exception\HtmlResponseException;
use d0niek\Whereiscash\Http\ResponseInterface;
use d0niek\Whereiscash\Http\SessionInterface;
use Ds\Map;

/**
 * @author Damian Glinkowski <damianglinkowski@gmail.com>
 */
class HtmlResponse implements ResponseInterface
{
    /**
     * @var string
     */
    private $viewPath;

    /**
     * @var string
     */
    private $template;

    /**
     * @var \Ds\Map
     */
    private $parameters;

    /**
     * @var \d0niek\Whereiscash\Http\SessionInterface
     */
    private $session;

    /**
     * @var string
     */
    private $baseView;

    /**
     * HtmlResponse constructor.
     *
     * @param string $viewPath
     * @param string $template
     * @param \Ds\Map|null $parameters
     * @param \d0niek\Whereiscash\Http\SessionInterface $session
     */
    public function __construct(string $viewPath, string $template, Map $parameters = null, SessionInterface $session)
    {
        $this->viewPath = $viewPath;
        $this->template = $template;
        $this->parameters = $parameters ?? new Map();
        $this->session = $session;

        $this->baseView = $this->getTemplateFile('base');
    }

    public function getHtml(): string
    {
        $template = $this->getTemplateFile($this->template);
        $this->parameters->put('template', $template);
        extract($this->parameters->toArray());

        ob_start();
        include_once($this->baseView);
        $html = ob_get_clean();

        return $html;
    }

    /**
     * @param string $templateName
     *
     * @return string
     * @throws \d0niek\Whereiscash\Exception\HtmlResponseException
     */
    protected function getTemplateFile(string $templateName): string
    {
        $templateFile = str_replace(':', '/', $templateName);
        $templateFile = $this->viewPath . '/' . $templateFile . '.phtml';
        if (file_exists($templateFile)) {
            return $templateFile;
        }

        throw new HtmlResponseException('Could not find template "' . $templateName . '"');
    }

    //region Getters & Setters

    /**
     * @return string
     */
    public function getTemplate(): string
    {
        return $this->template;
    }

    /**
     * @param string $template
     */
    public function setTemplate(string $template)
    {
        $this->template = $template;
    }

    /**
     * @return \Ds\Map
     */
    public function getParameters(): Map
    {
        return $this->parameters;
    }

    /**
     * @param \Ds\Map $parameters
     */
    public function setParameters(Map $parameters)
    {
        $this->parameters = $parameters;
    }

    //endregion Getters & Setters
}
