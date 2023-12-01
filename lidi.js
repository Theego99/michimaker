function lidi (inst) {

  // (A) DEFAULT STATUS + CSS WRAPPER CLASS
  console.log(inst.status, "lidi status");
  if (!inst.status) { inst.status = 0; }
  inst.hWrap.classList.add("lidiWrap");

  // (B) ATTACH LIKE & DISLIKE BUTTON
  inst.hUp = document.createElement("div");
  inst.hDown = document.createElement("div");
  inst.hUp.className = "lidiUp";
  inst.hDown.className = "lidiDown";
  if (inst.status==1) { inst.hUp.classList.add("set"); }
  if (inst.status==-1) { inst.hDown.classList.add("set"); }
  inst.hWrap.appendChild(inst.hUp);
  inst.hWrap.appendChild(inst.hDown);

  // (C) ATTACH LIKE & DISLIKE COUNT
  if (inst.count) {
    // (C1) LIKE & DISLIKE COUNT HTML
    inst.hUpCount = document.createElement("div");
    inst.hUpCount.className = "lidiUpCount";
    inst.hUpCount.innerHTML = inst.count;
    console.log(inst.count);
    inst.hWrap.classList.add("count");
    inst.hWrap.appendChild(inst.hUpCount, inst.hDown);

    // (C2) UPDATE LIKE & DISLIKE COUNT
    inst.recount = count => {
      inst.count = count;
      inst.hUpCount.innerHTML = count;
    };
  }

  // (D) TOGGLE LIKE/DISLIKE
  inst.updown = up => {
    // (D1) UPDATE STATUS FLAG
    if (up) { inst.status = inst.status == 1 ? 0 : 1; }
    else { inst.status = inst.status == -1 ? 0 : -1; }

    // (D2) UPDATE LIKE/DISLIKE CSS
    if (inst.status==1) {
      inst.hUp.classList.add("set");
      inst.hDown.classList.remove("set");
    } else if (inst.status==-1) {
      inst.hUp.classList.remove("set");
      inst.hDown.classList.add("set");
    } else {
      inst.hUp.classList.remove("set");
      inst.hDown.classList.remove("set");
    }

    // (D3) TRIGGER CHANGE
    inst.change(inst.status);
  };

  // (E) ENABLE/DISABLE
  inst.enable = () => {
    inst.hUp.onclick = () => inst.updown(true);
    inst.hDown.onclick = () => inst.updown(false);
  };
  inst.disable = () => {
    inst.hUp.onclick = "";
    inst.hDown.onclick = "";
  };
  inst.enable();

  // (F) DONE
  return inst;
}