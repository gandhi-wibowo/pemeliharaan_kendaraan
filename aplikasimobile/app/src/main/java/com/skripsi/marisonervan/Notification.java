package com.skripsi.marisonervan;

import android.app.ProgressDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.support.v7.app.AlertDialog;
import android.support.v7.app.AppCompatActivity;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ListView;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.skripsi.marisonervan.adapter.NotificationAdapter;
import com.skripsi.marisonervan.model.NotificationModel;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.File;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

public class Notification extends AppCompatActivity {

    private ProgressDialog progressDialog;

    private List<NotificationModel> notificationList = new ArrayList<NotificationModel>();
    private ListView listView;
    private NotificationAdapter adapter;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_notification);
        CekKoneksi();
        listView = (ListView) findViewById(R.id.list);
        adapter = new NotificationAdapter(this,notificationList);
        listView.setAdapter(adapter);
        progressDialog = new ProgressDialog(this);
        progressDialog.setMessage("Loading...");
        progressDialog.show();
        GetNotif();
        listView.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                NotificationModel notificationModel = notificationList.get(position);

                Intent intent = new Intent(getApplicationContext(),NotificationDetail.class);
                Bundle b = new Bundle();
                b.putString("no_polisi",notificationModel.getNoPolisi());
                b.putString("nama_mobil",notificationModel.getMerk());
                b.putString("jenis_mobil",notificationModel.getJenisKendaraan());
                b.putString("posisi_stnk",notificationModel.getPosisiStnk());
                b.putString("posisi_bpkb",notificationModel.getPosisiBpkb());
                b.putString("notifikasi",notificationModel.getPesanNotif());
                intent.putExtras(b);
                startActivity(intent);
            }
        });

    }
    private void GetNotif(){
        StringRequest stringRequest = new StringRequest(Request.Method.POST, Constant.url_notifikasi,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        try {
                            JSONArray jsonArray = new JSONArray(response);
                            for(int i=0; i< jsonArray.length();i++){
                                JSONObject jsonObject = jsonArray.getJSONObject(i);
                                NotificationModel notificationModel = new NotificationModel();
                                notificationModel.setIdNotifikasi(jsonObject.getString("id_notifikasi"));
                                notificationModel.setNoPolisi(jsonObject.getString("no_polisi"));
                                notificationModel.setJenisKendaraan(jsonObject.getString("jenis"));
                                notificationModel.setMerk(jsonObject.getString("merk"));
                                notificationModel.setPosisiBpkb(jsonObject.getString("posisi_bpkb"));
                                notificationModel.setPosisiStnk(jsonObject.getString("posisi_stnk"));
                                notificationModel.setJudulNotif(jsonObject.getString("judul_notifikasi"));
                                notificationModel.setPesanNotif(jsonObject.getString("isi_notifikasi"));
                                notificationList.add(notificationModel);
                            }
                            adapter.notifyDataSetChanged();
                            hidePDialog();
                        } catch (JSONException e) {
                            hidePDialog();
                            e.printStackTrace();
                        }

                    }
                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        hidePDialog();
                        System.out.println(error);
                    }
                }
        ) {
            protected Map<String, String> getParams() {
                Map<String, String> params = new HashMap<String, String>();
                params.put("getNotif","");
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
    private void hidePDialog() {
        if(progressDialog != null){
            progressDialog.dismiss();
            progressDialog = null;
        }
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
