<?php

namespace Framework\View;

class ExpressionRenderer
{
    public function renderExtends($argument = null)
    {
        return "<?php view()->extend({$argument}); ?>\r\n";
    }

    public function renderEcho($argument)
    {
        return "<?php echo {$argument}; ?>";
    }

    public function renderSection($argument)
    {
        return "<?php view()->startSection({$argument}); ?>\r\n";
    }

    public function renderEndsection()
    {
        return "<?php view()->endSection(); ?>\r\n";
    }

    public function renderInclude($argument)
    {
        return "<?php echo view()->includeView({$argument}); ?>\r\n";
    }

    public function renderYield($argument)
    {
        return "<?php echo view()->yield({$argument}); ?>\r\n";
    }

    public function renderLang($argument)
    {
        return "<?php echo __({$argument}); ?>";
    }

    public function renderForeach($argument)
    {
        return "<?php foreach ({$argument}): ?>\r\n";
    }

    public function renderEndforeach()
    {
        return "<?php endforeach; ?>\r\n";
    }

    public function renderFor($argument)
    {
        return "<?php for ({$argument}): ?>\r\n";
    }

    public function renderEndfor()
    {
        return "<?php endfor; ?>";
    }

    public function renderIf($argument)
    {
        return "<?php if ({$argument}): ?>\r\n";
    }

    public function renderElseif($argument)
    {
        return "<?php elseif ({$argument}): ?>\r\n";
    }

    public function renderElse()
    {
        return "<?php else: ?>\r\n";
    }

    public function renderEndif()
    {
        return "<?php endif; ?>\r\n";
    }
}