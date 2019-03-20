function adjustPointValue(PV, actualPilotSkill) {

	// Calculation of PointValue according to changed pilot skill
	// https://bg.battletech.com/wp-content/uploads/2018/09/Alpha-Strike-2018-06-06-v2.4.pdf?x64300

	var tempSkill = actualPilotSkill - 4;
	var tempPV = PV;

	if (tempSkill < 0) {						// Pilot is better than the default (4)
		if (PV < 15) {
			tempPV = tempPV + (1 * Math.abs(tempSkill));
		} else if (PV < 25) {
			tempPV = tempPV + (2 * Math.abs(tempSkill));
		} else if (PV < 35) {
			tempPV = tempPV + (3 * Math.abs(tempSkill));
		} else if (PV < 45) {
			tempPV = tempPV + (4 * Math.abs(tempSkill));
		} else if (PV < 55) {
			tempPV = tempPV + (5 * Math.abs(tempSkill));
		} else if (PV < 65) {
			tempPV = tempPV + (6 * Math.abs(tempSkill));
		} else if (PV < 75) {
			tempPV = tempPV + (7 * Math.abs(tempSkill));
		} else if (PV < 85) {
			tempPV = tempPV + (8 * Math.abs(tempSkill));
		} else if (PV < 95) {
			tempPV = tempPV + (9 * Math.abs(tempSkill));
		} else if (PV < 105) {
			tempPV = tempPV + (10 * Math.abs(tempSkill));
		} else if (PV < 115) {
			tempPV = tempPV + (11 * Math.abs(tempSkill));
		} else if (PV < 125) {
			tempPV = tempPV + (12 * Math.abs(tempSkill));
		}
	} else if (tempSkill == 0) {				// Pilot is default (4)
		tempPV = PV;
	} else if (tempSkill > 0) {					// Pilot is worse than the default (4)
		if (PV < 7) {
			tempPV = tempPV - (1 * Math.abs(tempSkill));
		} else if (PV < 12) {
			tempPV = tempPV - (2 * Math.abs(tempSkill));
		} else if (PV < 17) {
			tempPV = tempPV - (3 * Math.abs(tempSkill));
		} else if (PV < 22) {
			tempPV = tempPV - (4 * Math.abs(tempSkill));
		} else if (PV < 27) {
			tempPV = tempPV - (5 * Math.abs(tempSkill));
		} else if (PV < 32) {
			tempPV = tempPV - (6 * Math.abs(tempSkill));
		} else if (PV < 37) {
			tempPV = tempPV - (7 * Math.abs(tempSkill));
		} else if (PV < 42) {
			tempPV = tempPV - (8 * Math.abs(tempSkill));
		} else if (PV < 47) {
			tempPV = tempPV - (9 * Math.abs(tempSkill));
		} else if (PV < 52) {
			tempPV = tempPV - (10 * Math.abs(tempSkill));
		} else if (PV < 57) {
			tempPV = tempPV - (11 * Math.abs(tempSkill));
		} else if (PV < 62) {
			tempPV = tempPV - (12 * Math.abs(tempSkill));
		} else if (PV < 67) {
			tempPV = tempPV - (13 * Math.abs(tempSkill));
		} else if (PV < 72) {
			tempPV = tempPV - (14 * Math.abs(tempSkill));
		} else if (PV < 77) {
			tempPV = tempPV - (15 * Math.abs(tempSkill));
		} else if (PV < 82) {
			tempPV = tempPV - (16 * Math.abs(tempSkill));
		} else if (PV < 87) {
			tempPV = tempPV - (17 * Math.abs(tempSkill));
		} else if (PV < 92) {
			tempPV = tempPV - (18 * Math.abs(tempSkill));
		} else if (PV < 97) {
			tempPV = tempPV - (19 * Math.abs(tempSkill));
		} else if (PV < 102) {
			tempPV = tempPV - (20 * Math.abs(tempSkill));
		} else if (PV < 107) {
			tempPV = tempPV - (21 * Math.abs(tempSkill));
		} else if (PV < 112) {
			tempPV = tempPV - (22 * Math.abs(tempSkill));
		} else if (PV < 117) {
			tempPV = tempPV - (23 * Math.abs(tempSkill));
		} else if (PV < 122) {
			tempPV = tempPV - (24 * Math.abs(tempSkill));
		}
	}
	return tempPV;
}
