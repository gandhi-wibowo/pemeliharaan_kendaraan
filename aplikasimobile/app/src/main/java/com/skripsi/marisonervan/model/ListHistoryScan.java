package com.skripsi.marisonervan.model;


public class ListHistoryScan {
    private String NoPolisi,TglCari;
    public ListHistoryScan(){}
    public ListHistoryScan(String NoPolisi, String TglCari){
        this.NoPolisi = NoPolisi;
        this.TglCari = TglCari;
    }

    public String getNoPolisi() {
        return NoPolisi;
    }

    public void setNoPolisi(String noPolisi) {
        NoPolisi = noPolisi;
    }

    public String getTglCari() {
        return TglCari;
    }

    public void setTglCari(String tglCari) {
        TglCari = tglCari;
    }


}
