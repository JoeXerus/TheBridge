<?php

namespace Piyush;

use JsonException;
use Piyush\Arena\Arena;
use Piyush\Arena\EmptyArenaChooser;
use Piyush\Data\Data;
use pocketmine\entity\Entity;
use pocketmine\entity\EntityFactory;
use pocketmine\entity\Human;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\world\World;
use pocketmine\entity\EntityDataHelper as Helper;

use pocketmine\nbt\tag\CompoundTag;

class Main extends PluginBase implements Listener{


    private static Main $instance;


    /** @var EL $eventListener */
    public EL $eventListener;

    /** @var Command[] $cmd */
    public array $cmd = [];

    /** @var Arena[] $arena */
    public array $arena = [];

    /** @var Data */
    public Data $data;
    public EmptyArenaChooser $emptyArenaChooser;

    public function onEnable() : void {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->eventListener = new EL($this);
        $this->data = new Data($this);
        $this->emptyArenaChooser = new EmptyArenaChooser($this);
        $entityClass = NPChuman::class;
        EntityFactory::getInstance()->register($entityClass, function(World $world, CompoundTag $nbt) use ($entityClass): Entity {
            return new $entityClass(Helper::parseLocation($nbt, $world), Human::parseSkinNBT($nbt), $nbt);
        }, [$entityClass]);
    $this->getServer()->getPluginManager()->registerEvents($this->eventListener, $this);
        $this->getServer()->getCommandMap()->register("thebridge", $this->cmd[] = new commands($this));
       }


    /**
     * @throws JsonException
     */
    public function onDisable() : void{
        $this->data->saveArenas();
    }


    public static function getInstance(): Main {
        return self::$instance;
    }
}
