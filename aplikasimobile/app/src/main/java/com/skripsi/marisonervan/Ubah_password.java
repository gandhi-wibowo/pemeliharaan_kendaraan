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
import android.widget.EditText;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;

import org.json.JSONException;
import org.json.JSONObject;

import java.io.File;
import java.util.HashMap;
import java.util.Map;

public class Ubah_password extends AppCompatActivity {
    Button BtnPwd;
    EditText Old, New;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_ubah_password);
        CekKoneksi();
        BtnPwd = (Button) findViewById(R.id.btPwd);
        Old = (EditText) findViewById(R.id.pwdOld);
        New = (EditText) findViewById(R.id.pwdNew);

        BtnPwd.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                String pwdBaru = New.getText().toString();
                String pwdLama = Old.getText().toString();
                String idUser = GetShared("idUser","idKey");
                UbahPwd(pwdBaru,pwdLama,idUser);

            }
        });
    }
    private String GetShared(String Name, String Key){
        SharedPreferences settings = getSharedPreferences(Name, Context.MODE_PRIVATE);
        String data = settings.getString(Key,"");
        return data;
    }
    private void UbahPwd(final String pwdBaru, final String pwdLama, final String idUser){
        StringRequest stringRequest = new StringRequest(Request.Method.POST, Constant.url_updPassword,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        try {
                            JSONObject jsonObject = new JSONObject(response);
                            if(jsonObject.getString("status").equals("sukses")){
                                // kalau sukses ?
                                Toast.makeText(getApplicationContext(),"Password Telah dirubah ",Toast.LENGTH_LONG).show();
                                LogOut();
                            }
                            else{
                                Toast.makeText(getApplicationContext(),"Gagal merubah password ",Toast.LENGTH_LONG).show();
                            }
                        } catch (JSONException e) {
                            Toast.makeText(getApplicationContext(),"Gagal merubah password ",Toast.LENGTH_LONG).show();
                            e.printStackTrace();
                        }
                    }
                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        Toast.makeText(getApplicationContext(),"Gagal merubah password ",Toast.LENGTH_LONG).show();
                        System.out.println(error);
                    }
                }
        ) {
            protected Map<String, String> getParams() {
                Map<String, String> params = new HashMap<String, String>();
                params.put("pwdBaru", pwdBaru);
                params.put("pwdLama", pwdLama);
                params.put("idUser" , idUser);
                return params;
            }
        };
        RequestQueue requestQueue = Volley.newRequestQueue(this);
        requestQueue.add(stringRequest);
    }
    @Override
    public void onBackPressed() {
        Intent intent = new Intent(getApplicationContext(),MainActivity.class);
        startActivity(intent);
    }

    private void LogOut(){
        DeletePref("password");
        DeletePref("idUser");
        DeletePref("username");
        DeletePref("tipe_user");
        Intent intent = new Intent(getApplicationContext(),Login.class).setFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
        startActivity(intent);
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
                                    Toast.makeText(Ubah_password.this,"Password Telah berubah", Toast.LENGTH_LONG).show();
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
                            AlertDialog.Builder builder = new AlertDialog.Builder(Ubah_password.this);
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
                        AlertDialog.Builder builder = new AlertDialog.Builder(Ubah_password.this);
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
