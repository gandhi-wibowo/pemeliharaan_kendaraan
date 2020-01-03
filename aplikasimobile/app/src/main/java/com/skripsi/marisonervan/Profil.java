package com.skripsi.marisonervan;

import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.support.v7.app.AlertDialog;
import android.support.v7.app.AppCompatActivity;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.File;
import java.util.HashMap;
import java.util.Map;

public class Profil extends AppCompatActivity {

    TextView NamaPengguna, NamaLengkap, TypeUser,NoTelp;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_profil);
        NamaPengguna = (TextView) findViewById(R.id.namaPengguna);
        NamaLengkap = (TextView) findViewById(R.id.namaLengkap);
        TypeUser = (TextView) findViewById(R.id.typeUser);
        NoTelp = (TextView) findViewById(R.id.noHp);
        CekKoneksi();
        GetProfil();
    }

    private void GetProfil(){
        final String idUser = GetShared("idUser","idKey");
        StringRequest stringRequest = new StringRequest(Request.Method.POST, Constant.url_profil,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        try {
                            JSONArray jsonArray = new JSONArray(response);
                            JSONObject jsonObject = jsonArray.getJSONObject(0);
                            NamaPengguna.setText(jsonObject.getString("username"));
                            NamaLengkap.setText(jsonObject.getString("namalengkap"));
                            TypeUser.setText(jsonObject.getString("tipe_user"));
                            NoTelp.setText(jsonObject.getString("no_telp"));

                        } catch (JSONException e) {
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
                params.put("id_user",idUser );
                params.put("profil", "Ya");
                return params;
            }
        };
        RequestQueue requestQueue = Volley.newRequestQueue(this);
        requestQueue.add(stringRequest);
    }


    private void DeletePref(String prefname){
        String filePath = getApplicationContext().getFilesDir().getParent()+"/shared_prefs/"+prefname +".xml";
        File deletePrefFile = new File(filePath);
        System.out.println(deletePrefFile.delete());
    }
    private String GetShared(String Name, String Key){
        SharedPreferences settings = getSharedPreferences(Name, Context.MODE_PRIVATE);
        String data = settings.getString(Key,"");
        return data;
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
