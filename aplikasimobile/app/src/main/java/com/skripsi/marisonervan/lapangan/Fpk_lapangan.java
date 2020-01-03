package com.skripsi.marisonervan.lapangan;

import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.support.v7.app.AlertDialog;
import android.support.v7.app.AppCompatActivity;
import android.view.View;
import android.widget.ArrayAdapter;
import android.widget.AutoCompleteTextView;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Spinner;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.JsonArrayRequest;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.skripsi.marisonervan.Constant;
import com.skripsi.marisonervan.Login;
import com.skripsi.marisonervan.MainActivity;
import com.skripsi.marisonervan.R;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.File;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.Map;

public class Fpk_lapangan extends AppCompatActivity {

    String[] kerjaan = {"asuransi", "kir", "pajak", "service", "stnk"};
    ArrayList<String> noPol = new ArrayList<String>();
    Spinner JenisKerjaan;
    AutoCompleteTextView NoPolisi;
    Button Ajukan;
    EditText Keterangan;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_fpk_lapangan);
        CekKoneksi();



        Keterangan = (EditText) findViewById(R.id.keterangan);
        NoPolisi = (AutoCompleteTextView) findViewById(R.id.noPolisi);
        Bundle b = getIntent().getExtras();
        if(b != null){
            final String nopol = b.getString("noPolisi");
            NoPolisi.setText(nopol);
        }

        GetNopol();



        JenisKerjaan =(Spinner) findViewById(R.id.jenisKerjaan);
        ArrayAdapter<String> jenisKerjaans = new ArrayAdapter<String>(this,R.layout.spinner_item,kerjaan);
        jenisKerjaans.setDropDownViewResource(R.layout.spinner_dropdown_item);
        JenisKerjaan.setAdapter(jenisKerjaans);

        Ajukan = (Button) findViewById(R.id.ajukan);
        Ajukan.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                final String noPolisi = NoPolisi.getText().toString();
                final String jenisKerjaan = JenisKerjaan.getSelectedItem().toString();
                final String keterangan = Keterangan.getText().toString();
                final String idUser = GetShared("idUser","idKey");
                if(validate()){
                    StringRequest stringRequest = new StringRequest(Request.Method.POST, Constant.url_ajukanFpk,
                            new Response.Listener<String>() {
                                @Override
                                public void onResponse(String response) {
                                    try {
                                        JSONObject jsonObject = new JSONObject(response);
                                        if(jsonObject.getString("status").equals("sukses")){
                                            Toast.makeText(getApplicationContext(),"Menunggu Konfirmasi",Toast.LENGTH_LONG).show();
                                            Intent intent = new Intent(getApplicationContext(), MainActivity.class);
                                            startActivity(intent);
                                        }
                                        else{
                                            Toast.makeText(getApplicationContext(),"Gagal Mengajukan! FPK ini masih dalam proses pengajuan atau status pending.",Toast.LENGTH_LONG).show();
                                            Intent intent = new Intent(getApplicationContext(), MainActivity.class);
                                            startActivity(intent);
                                        }
                                    } catch (JSONException e) {
                                        e.printStackTrace();
                                    }
                                }
                            },
                            new Response.ErrorListener() {
                                @Override
                                public void onErrorResponse(VolleyError error) {
                                    System.out.println("Gagal :" + error);
                                }
                            }){
                        @Override
                        public String getBodyContentType(){
                            return "application/x-www-form-urlencoded";
                        }
                        protected Map<String, String> getParams(){
                            Map<String, String> params = new HashMap<String, String>();
                            params.put("jk",jenisKerjaan);
                            params.put("ket",keterangan);
                            params.put("plat",noPolisi);
                            params.put("idUser",idUser);
                            params.put("insert","Ajukan");
                            return params;
                        }
                    };
                    RequestQueue requestQueue = Volley.newRequestQueue(getApplicationContext());
                    requestQueue.add(stringRequest);
                }




            }
        });
    }

    private void GetNopol(){
        JsonArrayRequest mobilReq = new JsonArrayRequest(Constant.url_nopol,
                new Response.Listener<JSONArray>() {
                    @Override
                    public void onResponse(JSONArray response) {
                        try {

                            for(int i=0; i< response.length();i++){
                                JSONObject jsonObject = response.getJSONObject(i);
                                String nomor = jsonObject.getString("no_polisi");
                                noPol.add(i,nomor);
                            }

                            ArrayAdapter<String> noPolisi = new ArrayAdapter<String>(getApplicationContext(),R.layout.spinner_dropdown_item, noPol);

                            NoPolisi.setThreshold(2);
                            NoPolisi.setAdapter(noPolisi);

                        } catch (JSONException e) {
                            e.printStackTrace();
                        }

                    }
                }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {


            }
        });
        RequestQueue mRequestQueue  = Volley.newRequestQueue(getApplicationContext());
        mRequestQueue.add(mobilReq);
    }

    public boolean validate(){
        boolean valid = true;

        if(Keterangan.getText().toString().isEmpty()){
            // kalau keterangan kosong
            Keterangan.setError("Kolom ini tidak boleh kosong !");
            valid = false;
        }
        else {
            Keterangan.setError(null);
        }

        return valid;

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
