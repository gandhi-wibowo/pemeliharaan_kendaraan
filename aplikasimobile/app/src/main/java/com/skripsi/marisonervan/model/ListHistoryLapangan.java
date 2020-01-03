package com.skripsi.marisonervan.model;


public class ListHistoryLapangan {
    private String NoPolisi;
    private String TglCari;



    private String IdFpk;
    private String StatusFpk;
    public ListHistoryLapangan(){}
    public ListHistoryLapangan(String NoPolisi, String TglCari, String StatusFpk,String IdFpk){
        this.NoPolisi = NoPolisi;
        this.TglCari = TglCari;
        this.StatusFpk = StatusFpk;
        this.IdFpk = IdFpk;
    }
    public String getIdFpk() {return IdFpk;    }
    public void setIdFpk(String idFpk) {IdFpk = idFpk;    }
    public String getStatusFpk() {
        return StatusFpk;
    }
    public void setStatusFpk(String statusFpk) { StatusFpk = statusFpk; }
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
