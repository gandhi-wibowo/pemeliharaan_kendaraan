package com.skripsi.marisonervan;

import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.support.v7.app.AlertDialog;
import android.support.v7.app.AppCompatActivity;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.skripsi.marisonervan.lapangan.Fpk_lapangan;
import com.skripsi.marisonervan.lapangan.History_lapangan;
import com.skripsi.marisonervan.manager.History_manager;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.File;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.HashMap;
import java.util.Map;

public class Detail extends AppCompatActivity {
    Button AjukanFpk;

    TextView NoMobil, NamaMobil,Jenis,NoMesin,NoRangka,Status,NamaBpkb,PosBpkb,NamaStnk,PosStnk,BerStnk,BerAsuransi,BerPajak,BerService,BerKir,TitleAsuransi,TitleKir,Titlenamapengguna,Titlejabatanpengguna, Titlenotelp;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_detail);
        CekKoneksi();
        AjukanFpk = (Button) findViewById(R.id.ajukanFpk);
        Titlenamapengguna = (TextView) findViewById(R.id.namapenggunakendaraan) ;
        Titlejabatanpengguna = (TextView) findViewById(R.id.jabatanpengguna);
        Titlenotelp = (TextView) findViewById(R.id.notelp);
        NoMobil = (TextView) findViewById(R.id.noMobil);
        NamaMobil = (TextView) findViewById(R.id.namaMobil);
        Jenis = (TextView) findViewById(R.id.jenisMobil);
        NoMesin = (TextView) findViewById(R.id.noMesin);
        NoRangka = (TextView) findViewById(R.id.noRangka);
        Status = (TextView) findViewById(R.id.status);
        NamaBpkb = (TextView) findViewById(R.id.namaBpkb);
        PosBpkb = (TextView) findViewById(R.id.posisiBpkb);
        NamaStnk = (TextView) findViewById(R.id.namaStnk);
        PosStnk = (TextView) findViewById(R.id.posisiStnk);
        BerStnk = (TextView) findViewById(R.id.berlakuStnk);
        BerAsuransi = (TextView) findViewById(R.id.berlakuAsuransi);
        BerPajak = (TextView) findViewById(R.id.berlakuPajak);
        BerService = (TextView) findViewById(R.id.berlakuService);
        BerKir = (TextView) findViewById(R.id.berlakuKir);
        TitleAsuransi = (TextView) findViewById(R.id.titleAsuransi);
        TitleKir = (TextView) findViewById(R.id.titleKir);


        Bundle b = getIntent().getExtras();
        String noMobil = b.getString("noMobil");
        GetMobil(noMobil);
        AjukanFpk.setVisibility(View.GONE);

        String tipeUser = GetShared("tipe_user","tipeKey");
        if(tipeUser.equals("slapangan")){
            AjukanFpk.setVisibility(View.VISIBLE);
        }
        AjukanFpk.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {

                Bundle b = new Bundle();
                b.putString("noPolisi", NoMobil.getText().toString());
                Intent intent = new Intent(getApplicationContext(), Fpk_lapangan.class);
                intent.putExtras(b);
                startActivity(intent);
            }
        });
    }
    private String Tanggal(String tanggal) throws ParseException {
        SimpleDateFormat curFormater = new SimpleDateFormat("yyyy-MM-dd");
        Date dateObj = curFormater.parse(tanggal);
        SimpleDateFormat postFormater = new SimpleDateFormat("dd-MMM-yyyy");
        return postFormater.format(dateObj);
    }
    private void GetMobil(final String noMobil){

        StringRequest stringRequest = new StringRequest(Request.Method.POST, Constant.url_mobil,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        try {
                            JSONArray jsonArray = new JSONArray(response);
                            JSONObject jsonObject = jsonArray.getJSONObject(0);
                            String noPol = jsonObject.getString("no_polisi");
                            String merk = jsonObject.getString("merk");
                            String jenis = jsonObject.getString("jenis");
                            String noMesin = jsonObject.getString("no_mesin");
                            String noRangka = jsonObject.getString("no_rangka");
                            String status = jsonObject.getString("status_kendaraan");
                            String namaBpkb = jsonObject.getString("nama_bpkb");
                            String posBpkb = jsonObject.getString("posisi_bpkb");
                            String namaStnk = jsonObject.getString("nama_stnk");
                            String posStnk = jsonObject.getString("posisi_stnk");
                            String stnk = Tanggal(jsonObject.getString("berlaku_stnk"));
                            String pajak = Tanggal(jsonObject.getString("berlaku_pajak"));
                            String service = Tanggal(jsonObject.getString("berlaku_service"));
                            String idKendaraan = jsonObject.getString("id_kendaraan");
                            String namapenggunak = jsonObject.getString("nama_pengguna") ;
                            String jabatanpenggunak = jsonObject.getString("jabatan_pengguna");
                            String notelppenggunak = jsonObject.getString("no_telp");


                            GetKir(idKendaraan);
                            GetAsuransi(idKendaraan);

                            NoMobil.setText(noPol);
                            NamaMobil.setText(merk);
                            Jenis.setText(jenis);
                            NoMesin.setText(noMesin);
                            NoRangka.setText(noRangka);
                            Status.setText(status);
                            NamaBpkb.setText(namaBpkb);
                            PosBpkb.setText(posBpkb);
                            NamaStnk.setText(namaStnk);
                            PosStnk.setText(posStnk);
                            BerStnk.setText(stnk);
                            BerPajak.setText(pajak);
                            BerService.setText(service);
                            Titlenamapengguna.setText(namapenggunak);
                            Titlejabatanpengguna.setText(jabatanpenggunak);
                            Titlenotelp.setText(notelppenggunak);

                        } catch (JSONException e) {
                            e.printStackTrace();
                        } catch (ParseException e) {
                            e.printStackTrace();
                        }
                    }
                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        System.out.println(error);
                    }
                }
        ) {
            protected Map<String, String> getParams() {
                Map<String, String> params = new HashMap<String, String>();
                params.put("detailMobil", noMobil);
                return params;
            }
        };
        RequestQueue requestQueue = Volley.newRequestQueue(this);
        requestQueue.add(stringRequest);
    }

    private void GetKir(final String idKendaraan){
        StringRequest stringRequest = new StringRequest(Request.Method.POST, Constant.url_mobil,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        try {
                            JSONArray jsonArray = new JSONArray(response);
                            JSONObject jsonObject = jsonArray.getJSONObject(0);
                            String berlakuKir = Tanggal(jsonObject.getString("berlaku_kir"));
                            BerKir.setText(berlakuKir);
                        } catch (JSONException e) {
                            BerKir.setVisibility(View.GONE);
                            TitleKir.setVisibility(View.GONE);
                        } catch (ParseException e) {
                            e.printStackTrace();
                        }
                    }
                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        BerKir.setVisibility(View.GONE);
                        TitleKir.setVisibility(View.GONE);
                    }
                }
        ) {
            protected Map<String, String> getParams() {
                Map<String, String> params = new HashMap<String, String>();
                params.put("kir", idKendaraan);
                return params;
            }
        };
        RequestQueue requestQueue = Volley.newRequestQueue(this);
        requestQueue.add(stringRequest);
    }
    private void GetAsuransi(final String idKendaraan){
        StringRequest stringRequest = new StringRequest(Request.Method.POST, Constant.url_mobil,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        try {
                            JSONArray jsonArray = new JSONArray(response);
                            JSONObject jsonObject = jsonArray.getJSONObject(0);
                            String berlakuAsuransi = Tanggal(jsonObject.getString("berlaku_asuransi"));
                            BerAsuransi.setText(berlakuAsuransi);
                        } catch (JSONException e) {
                            BerAsuransi.setVisibility(View.GONE);
                            TitleAsuransi.setVisibility(View.GONE);
                        } catch (ParseException e) {
                            e.printStackTrace();
                        }

                    }
                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        BerAsuransi.setVisibility(View.GONE);
                        TitleAsuransi.setVisibility(View.GONE);
                    }
                }
        ) {
            protected Map<String, String> getParams() {
                Map<String, String> params = new HashMap<String, String>();
                params.put("asuransi", idKendaraan);
                return params;
            }
        };
        RequestQueue requestQueue = Volley.newRequestQueue(this);
        requestQueue.add(stringRequest);
    }
    @Override
    public void onBackPressed() {
        Intent intent = new Intent(getApplicationContext(),HistoryScan.class);
        startActivity(intent);
    }

    private String GetShared(String Name, String Key){
        SharedPreferences settings = getSharedPreferences(Name, Context.MODE_PRIVATE);
        String data = settings.getString(Key,"");
        return data;
    }
    private void DeletePref(String prefname){
        String filePath = getApplicationContext().getFilesDir().getParent()+"/shared_prefs/"+prefname +".xml";
        File deletePrefFile = new File(filePath);
        System.out.println(deletePrefFile.delete());
    }
    private void CekLogin(){
        if(GetShared("username","userKey").isEmpty()){
            Intent intent = new Intent(getApplicationContext(),Login.class).setFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
            startActivity(intent);
        }
        else {
            final String username = GetShared("username","userKey");
            final String password = GetShared("password","pwdKey");
            StringRequest stringRequest = new StringRequest(Request.Method.POST, Constant.url_login,
                    new Response.Listener<String>() {
                        @Override
                        public void onResponse(String response) {
                            try {
                                JSONObject jsonObject = new JSONObject(response);
                                if (jsonObject.getString("status").equals("gagal")){
                                    DeletePref("password");
                                    DeletePref("idUser");
                                    DeletePref("username");
                                    DeletePref("tipe_user");
                                    Toast.makeText(getApplicationContext(),"Password Telah berubah", Toast.LENGTH_LONG).show();
                                    Intent intent = new Intent(getApplicationContext(),Login.class).setFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
                                    startActivity(intent);
                                }
                            }
                            catch (Exception e){
                                e.printStackTrace();
                            }
                        }
                    },
                    new Response.ErrorListener() {
                        @Override
                        public void onErrorResponse(VolleyError error) {
                            // kalau datanya gk cocok
                            Intent intent = new Intent(getApplicationContext(),Login.class).setFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
                            startActivity(intent);
                        }
                    }
            ) {
                @Override
                public String getBodyContentType() {
                    return "application/x-www-form-urlencoded";
                }

                protected Map<String, String> getParams() {
                    Map<String, String> params = new HashMap<String, String>();
                    params.put("username", username);
                    params.put("password", password);
                    params.put("cekLogin", "CekLogin");
                    return params;
                }
            };
            RequestQueue requestQueue = Volley.newRequestQueue(this);
            requestQueue.add(stringRequest);
        }
    }
    private void CekKoneksi(){
        StringRequest stringRequest = new StringRequest(Request.Method.POST, Constant.url_login,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        try {
                            JSONObject jsonObject = new JSONObject(response);
                            if (jsonObject.getString("status").equals("online")){
                                CekLogin();
                            }
                        } catch (JSONException e) {
                            AlertDialog.Builder builder = new AlertDialog.Builder(getApplicationContext());
                            builder.setTitle("! Alert");
                            builder.setMessage("Terjadi msalah saat menghubungi Server !");
                            builder.setNegativeButton("Keluar", new DialogInterface.OnClickListener() {
                                @Override
                                public void onClick(DialogInterface dialog, int which) {
                                    finish();
                                }
                            });
                            builder.show();
                            e.printStackTrace();
                        }
                    }
                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        AlertDialog.Builder builder = new AlertDialog.Builder(getApplicationContext());
                        builder.setTitle("! Alert");
                        builder.setMessage("Terjadi msalah saat menghubungi Server !");
                        builder.setNegativeButton("Keluar", new DialogInterface.OnClickListener() {
                            @Override
                            public void onClick(DialogInterface dialog, int which) {
                                finish();
                            }
                        });
                        builder.show();
                    }
                }
        ) {
            @Override
            public String getBodyContentType() {
                return "application/x-www-form-urlencoded";
            }

            protected Map<String, String> getParams() {
                Map<String, String> params = new HashMap<String, String>();
                params.put("cekJaringan", "");
                return params;
            }
        };
        RequestQueue requestQueue = Volley.newRequestQueue(this);
        requestQueue.add(stringRequest);
    }

}
