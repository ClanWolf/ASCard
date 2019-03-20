function between(x, min, max) {
	return x >= min && x <= max;
}

function adjustPointValue(PV, actualPilotSkill) {

	// Calculation of PointValue according to changed pilot skill
	// https://bg.battletech.com/wp-content/uploads/2018/09/Alpha-Strike-2018-06-06-v2.4.pdf?x64300

	var tempSkill = actualPilotSkill - 4;
	var tempPV = PV;

	if (tempSkill < 0) {						// Pilot is better than the default (4)
			   if (between(PV,   0,   7)) {
			tempPV = parseInt(tempPV) + ( 1 * Math.abs(tempSkill));
		} else if (between(PV,   8,  12)) {
			tempPV = parseInt(tempPV) + ( 2 * Math.abs(tempSkill));
		} else if (between(PV,  13,  17)) {
			tempPV = parseInt(tempPV) + ( 3 * Math.abs(tempSkill));
		} else if (between(PV,  18,  22)) {
			tempPV = parseInt(tempPV) + ( 4 * Math.abs(tempSkill));
		} else if (between(PV,  23,  27)) {
			tempPV = parseInt(tempPV) + ( 5 * Math.abs(tempSkill));
		} else if (between(PV,  28,  32)) {
			tempPV = parseInt(tempPV) + ( 6 * Math.abs(tempSkill));
		} else if (between(PV,  33,  37)) {
			tempPV = parseInt(tempPV) + ( 7 * Math.abs(tempSkill));
		} else if (between(PV,  38,  42)) {
			tempPV = parseInt(tempPV) + ( 8 * Math.abs(tempSkill));
		} else if (between(PV,  43,  47)) {
			tempPV = parseInt(tempPV) + ( 9 * Math.abs(tempSkill));
		} else if (between(PV,  48,  52)) {
			tempPV = parseInt(tempPV) + (10 * Math.abs(tempSkill));
		} else if (between(PV,  53,  57)) {
			tempPV = parseInt(tempPV) + (11 * Math.abs(tempSkill));
 		} else if (between(PV,  58,  62)) {
			tempPV = parseInt(tempPV) + (12 * Math.abs(tempSkill));
		} else if (between(PV,  63,  67)) {
			tempPV = parseInt(tempPV) + (13 * Math.abs(tempSkill));
		} else if (between(PV,  68,  72)) {
			tempPV = parseInt(tempPV) + (14 * Math.abs(tempSkill));
		} else if (between(PV,  73,  77)) {
			tempPV = parseInt(tempPV) + (15 * Math.abs(tempSkill));
		} else if (between(PV,  78,  82)) {
			tempPV = parseInt(tempPV) + (16 * Math.abs(tempSkill));
		} else if (between(PV,  83,  87)) {
			tempPV = parseInt(tempPV) + (17 * Math.abs(tempSkill));
		} else if (between(PV,  88,  92)) {
			tempPV = parseInt(tempPV) + (18 * Math.abs(tempSkill));
		} else if (between(PV,  93,  97)) {
			tempPV = parseInt(tempPV) + (19 * Math.abs(tempSkill));
		} else if (between(PV,  98, 102)) {
			tempPV = parseInt(tempPV) + (20 * Math.abs(tempSkill));
		} else if (between(PV, 103, 107)) {
			tempPV = parseInt(tempPV) + (21 * Math.abs(tempSkill));
		} else if (between(PV, 108, 112)) {
			tempPV = parseInt(tempPV) + (22 * Math.abs(tempSkill));
		}
	} else if (tempSkill == 0) {				// Pilot is default (4)
		tempPV = PV;
	} else if (tempSkill > 0) {					// Pilot is worse than the default (4)
			   if (between(PV,   0,  14)) {
			tempPV = parseInt(tempPV) - ( 1 * Math.abs(tempSkill));
		} else if (between(PV,  15,  24)) {
			tempPV = parseInt(tempPV) - ( 2 * Math.abs(tempSkill));
		} else if (between(PV,  25,  34)) {
			tempPV = parseInt(tempPV) - ( 3 * Math.abs(tempSkill));
		} else if (between(PV,  35,  44)) {
			tempPV = parseInt(tempPV) - ( 4 * Math.abs(tempSkill));
		} else if (between(PV,  45,  54)) {
			tempPV = parseInt(tempPV) - ( 5 * Math.abs(tempSkill));
		} else if (between(PV,  55,  64)) {
			tempPV = parseInt(tempPV) - ( 6 * Math.abs(tempSkill));
		} else if (between(PV,  65,  74)) {
			tempPV = parseInt(tempPV) - ( 7 * Math.abs(tempSkill));
		} else if (between(PV,  75,  84)) {
			tempPV = parseInt(tempPV) - ( 8 * Math.abs(tempSkill));
		} else if (between(PV,  85,  94)) {
			tempPV = parseInt(tempPV) - ( 9 * Math.abs(tempSkill));
		} else if (between(PV,  95, 104)) {
			tempPV = parseInt(tempPV) - (10 * Math.abs(tempSkill));
		} else if (between(PV, 105, 114)) {
			tempPV = parseInt(tempPV) - (11 * Math.abs(tempSkill));
		} else if (between(PV, 115, 124)) {
			tempPV = parseInt(tempPV) - (12 * Math.abs(tempSkill));
		} else if (between(PV, 125, 134)) {
			tempPV = parseInt(tempPV) - (13 * Math.abs(tempSkill));
		} else if (between(PV, 135, 144)) {
			tempPV = parseInt(tempPV) - (14 * Math.abs(tempSkill));
		}
	}
	return tempPV;
}
