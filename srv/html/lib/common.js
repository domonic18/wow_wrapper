  function RaceIcon(race, gender) {
    var iconPath = '';

    switch (race) {
      case 1:
        iconPath = (gender === 0) ? 'icons/race/Ui-charactercreate-races_human-male.png' : 'icons/race/Ui-charactercreate-races_human-female.png';
        break;
      case 2:
        iconPath = (gender === 0) ? 'icons/race/Ui-charactercreate-races_orc-male.png' : 'icons/race/Ui-charactercreate-races_orc-female.png';
        break;
      case 3:
        iconPath = (gender === 0) ? 'icons/race/Ui-charactercreate-races_dwarf-male.png' : 'icons/race/Ui-charactercreate-races_dwarf-female.png';
        break;
      case 4:
        iconPath = (gender === 0) ? 'icons/race/Ui-charactercreate-races_nightelf-male.png' : 'icons/race/Ui-charactercreate-races_nightelf-female.png';
        break;
      case 5:
        iconPath = (gender === 0) ? 'icons/race/Ui-charactercreate-races_undead-male.png' : 'icons/race/Ui-charactercreate-races_undead-female.png';
        break;
      case 6:
        iconPath = (gender === 0) ? 'icons/race/Ui-charactercreate-races_tauren-male.png' : 'icons/race/Ui-charactercreate-races_tauren-female.png';
        break;
      case 7:
        iconPath = (gender === 0) ? 'icons/race/Ui-charactercreate-races_gnome-male.png' : 'icons/race/Ui-charactercreate-races_gnome-female.png';
        break;
      case 8:
        iconPath = (gender === 0) ? 'icons/race/Ui-charactercreate-races_troll-male.png' : 'icons/race/Ui-charactercreate-races_troll-female.png';
        break;
      case 10:
        iconPath = (gender === 0) ? 'icons/race/Ui-charactercreate-races_bloodelf-male.png' : 'icons/race/Ui-charactercreate-races_bloodelf-female.png';
        break;
      case 11:
        iconPath = (gender === 0) ? 'icons/race/Ui-charactercreate-races_draenei-male.png' : 'icons/race/Ui-charactercreate-races_draenei-female.png';
        break;
      case 22:
        iconPath = (gender === 0) ? 'icons/race/Ui-charactercreate-races_worgen-male.png' : 'icons/race/Ui-charactercreate-races_worgen-female.png';
        break;
      case 9:
        iconPath = (gender === 0) ? 'icons/race/Ui-charactercreate-races_goblin-male.png' : 'icons/race/Ui-charactercreate-races_goblin-female.png';
        break;
      case 24:
        iconPath = (gender === 0) ? 'icons/race/Ui-charactercreate-races_pandaren-male.png' : 'icons/race/Ui-charactercreate-races_pandaren-female.png';
        break;
    }

    return iconPath;
  }

  // 将金币数量转换为金币、银币、铜币格式
  function convertGoldToString(totalGold) {
    var gold = Math.floor(totalGold / 10000);
    var silver = Math.floor((totalGold % 10000) / 100);
    var copper = totalGold % 100;

    var goldIcon = `<img src="icons/money-gold.gif" class="money-image">`;
    var silverIcon = `<img src="icons/money-silver.gif" class="money-image">`;
    var copperIcon = `<img src="icons/money-copper.gif" class="money-image">`;

    return gold + goldIcon + silver + silverIcon + copper + copperIcon;
  }

  // 将在线状态显示为绿色原点+在线
  // &#9679：代表的是Unicode字符实体，表示的是一个实心圆点符号。
  function formatOnlineStatus() {
    return '<span style="color: green">&#9679;</span> 在线';
  }

  function getFactionIcon(faction) {
    var iconPath = '';
    switch (faction) {
      case 'Alliance':
        iconPath = 'icons/alliance.gif';
        break;
      case 'Horde':
        iconPath = 'icons/horde.gif';
        break;
      default:
        iconPath = 'icons/neutral.gif';
        break;
    }
    return `<img src="${iconPath}" class="faction-icon">`;
  }

  function generateCharacterLink(characterName) {
    var serverName = '阿拉希'; // 服务器名称
    return `<a href="http://lokta.cn:48733/character/${serverName}/${characterName}/achievements" class="armory_name">${characterName}</a>`;
  }