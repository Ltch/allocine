<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\ContainerCdYTaoV\srcDevDebugProjectContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/ContainerCdYTaoV/srcDevDebugProjectContainer.php') {
    touch(__DIR__.'/ContainerCdYTaoV.legacy');

    return;
}

if (!\class_exists(srcDevDebugProjectContainer::class, false)) {
    \class_alias(\ContainerCdYTaoV\srcDevDebugProjectContainer::class, srcDevDebugProjectContainer::class, false);
}

return new \ContainerCdYTaoV\srcDevDebugProjectContainer(array(
    'container.build_hash' => 'CdYTaoV',
    'container.build_id' => '4c9c16de',
    'container.build_time' => 1541602350,
), __DIR__.\DIRECTORY_SEPARATOR.'ContainerCdYTaoV');
