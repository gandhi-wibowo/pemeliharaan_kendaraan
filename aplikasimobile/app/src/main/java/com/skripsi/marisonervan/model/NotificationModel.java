package com.skripsi.marisonervan.model;

public class NotificationModel {
    private String NoPolisi;
    private String IdNotifikasi;
    private String JenisKendaraan;
    private String Merk;
    private String PosisiStnk;
    private String PosisiBpkb;
    private String JudulNotif;
    private String PesanNotif;

    public NotificationModel(){}

    public NotificationModel(String NoPolisi, String IdNotifikasi, String JenisKendaraan, String Merk, String PosisiStnk, String PosisiBpkb, String JudulNotif, String PesanNotif){
        this.NoPolisi = NoPolisi;
        this.IdNotifikasi = IdNotifikasi;
        this.JenisKendaraan = JenisKendaraan;
        this.Merk = Merk;
        this.PosisiStnk = PosisiStnk;
        this.PosisiBpkb = PosisiBpkb;
        this.JudulNotif = JudulNotif;
        this.PesanNotif = PesanNotif;

    }

    public String getJudulNotif() {
        return JudulNotif;
    }

    public void setJudulNotif(String judulNotif) {
        JudulNotif = judulNotif;
    }

    public String getPesanNotif() {
        return PesanNotif;
    }

    public void setPesanNotif(String pesanNotif) {
        PesanNotif = pesanNotif;
    }



    public String getIdNotifikasi() {
        return IdNotifikasi;
    }

    public void setIdNotifikasi(String idNotifikasi) {
        IdNotifikasi = idNotifikasi;
    }

    public String getJenisKendaraan() {
        return JenisKendaraan;
    }

    public void setJenisKendaraan(String jenisKendaraan) {
        JenisKendaraan = jenisKendaraan;
    }

    public String getMerk() {
        return Merk;
    }

    public void setMerk(String merk) {
        Merk = merk;
    }

    public String getNoPolisi() {
        return NoPolisi;
    }

    public void setNoPolisi(String noPolisi) {
        NoPolisi = noPolisi;
    }

    public String getPosisiBpkb() {
        return PosisiBpkb;
    }

    public void setPosisiBpkb(String posisiBpkb) {
        PosisiBpkb = posisiBpkb;
    }

    public String getPosisiStnk() {
        return PosisiStnk;
    }

    public void setPosisiStnk(String posisiStnk) {
        PosisiStnk = posisiStnk;
    }





}
