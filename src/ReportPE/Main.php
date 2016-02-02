<?php

  namespace ReportPE;
  
  use pocketmine\plugin\PluginBase;
  use pocketmine\event\Listener;
  use pocketmine\utils\TextFormat as TF;
  use pocketmine\command\Command;
  use pocketmine\command\CommandSender;
  
  class Main extends PluginBase implements Listener {
  
    public function dataFolder() {
    
      return $this->getDataFolder();
      
    }
    
    public function onEnable() {
    
      $this->getServer()->getPluginManager()->registerEvents($this, $this);
      
      if(!(file_exists($this->dataFolder()))) {
      
        @mkdir($this->dataFolder());
        
        chdir($this->dataFolder());
        
        touch("reports.txt");
        
        file_put_contents("reports.txt", "Player || Problem\n\n");
        
      }
      
    }
    
    public function onCommand(CommandSender $sender, Command $cmd, $label, array $args) {
    
      if(strtolower($cmd->getName()) === "report") {
      
        if(!(isset($args[0]))) {
        
          $sender->sendMessage(TF::RED . "Error: not enough args. Usage: /report < problem >");
          
          return true;
          
        } else {
        
          chdir($this->dataFolder());
        
          $player_name = $sender->getName();
          
          $player_display_name = $sender->getDisplayName();
          
          $problem = implode(" ", $args);
          
          file_put_contents("reports.txt", $player_name . " || " . $problem . "\n", FILE_APPEND);
          
          $sender->sendMessage(TF::GREEN . "Successfully saved your report!");
          
          return true;
          
        }
        
      }
      
      if(strtolower($cmd->getName()) === "reports") {
      
        chdir($this->dataFolder());
        
        $reports = file("reports.txt");
        
        foreach($reports as $report) {
        
          $sender->sendMessage(TF::YELLOW . $report);
          
        }
        
        return true;
        
      }
      
    }
    
  }
  
?>
