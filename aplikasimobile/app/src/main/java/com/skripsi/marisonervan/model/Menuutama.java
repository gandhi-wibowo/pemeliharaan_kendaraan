package com.skripsi.marisonervan.model;


public class Menuutama {
    private String namaMenu;
    private int icon;

    public Menuutama(String namaMenu, int icon){
        this.namaMenu = namaMenu;
        this.icon = icon;
    }
    public String getNamaMenu() {
        return namaMenu;
    }

    public void setNamaMenu(String namaMenu) {
        this.namaMenu = namaMenu;
    }

    public int getIcon() {
        return icon;
    }

    public void setIcon(int icon) {
        this.icon = icon;
    }


}
