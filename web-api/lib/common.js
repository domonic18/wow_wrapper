  function RaceIcon(race, gender) {
    var iconPath = '';

    switch (race) {
      case 1:
        iconPath = (gender === 0) ? 'race/Ui-charactercreate-races_human-male.png' : 'race/Ui-charactercreate-races_human-female.png';
        break;
      case 2:
        iconPath = (gender === 0) ? 'race/Ui-charactercreate-races_orc-male.png' : 'race/Ui-charactercreate-races_orc-female.png';
        break;
      case 3:
        iconPath = (gender === 0) ? 'race/Ui-charactercreate-races_dwarf-male.png' : 'race/Ui-charactercreate-races_dwarf-female.png';
        break;
      case 4:
        iconPath = (gender === 0) ? 'race/Ui-charactercreate-races_nightelf-male.png' : 'race/Ui-charactercreate-races_nightelf-female.png';
        break;
      case 5:
        iconPath = (gender === 0) ? 'race/Ui-charactercreate-races_undead-male.png' : 'race/Ui-charactercreate-races_undead-female.png';
        break;
      case 6:
        iconPath = (gender === 0) ? 'race/Ui-charactercreate-races_tauren-male.png' : 'race/Ui-charactercreate-races_tauren-female.png';
        break;
      case 7:
        iconPath = (gender === 0) ? 'race/Ui-charactercreate-races_gnome-male.png' : 'race/Ui-charactercreate-races_gnome-female.png';
        break;
      case 8:
        iconPath = (gender === 0) ? 'race/Ui-charactercreate-races_troll-male.png' : 'race/Ui-charactercreate-races_troll-female.png';
        break;
      case 10:
        iconPath = (gender === 0) ? 'race/Ui-charactercreate-races_bloodelf-male.png' : 'race/Ui-charactercreate-races_bloodelf-female.png';
        break;
      case 11:
        iconPath = (gender === 0) ? 'race/Ui-charactercreate-races_draenei-male.png' : 'race/Ui-charactercreate-races_draenei-female.png';
        break;
      case 22:
        iconPath = (gender === 0) ? 'race/Ui-charactercreate-races_worgen-male.png' : 'race/Ui-charactercreate-races_worgen-female.png';
        break;
      case 9:
        iconPath = (gender === 0) ? 'race/Ui-charactercreate-races_goblin-male.png' : 'race/Ui-charactercreate-races_goblin-female.png';
        break;
      case 24:
        iconPath = (gender === 0) ? 'race/Ui-charactercreate-races_pandaren-male.png' : 'race/Ui-charactercreate-races_pandaren-female.png';
        break;
    }

    return iconPath;
  }