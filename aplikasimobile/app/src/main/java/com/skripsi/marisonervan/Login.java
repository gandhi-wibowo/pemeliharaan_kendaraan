package com.skripsi.marisonervan;

import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
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

import java.util.HashMap;
import java.util.Map;

public class Login extends AppCompatActivity {
    private EditText EditName,EditPwd;
    String username,password;
    Button button;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);

        EditName = (EditText) findViewById(R.id.edithp);
        EditPwd = (EditText) findViewById(R.id.editpwd);
        button = (Button) findViewById(R.id.button2);
        button.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                username = EditName.getText().toString();
                password = EditPwd.getText().toString();
                Login(username,password);
            }
        });
    }

    private void Login(final String username, final String password){
        button.setEnabled(false);

        if (!validate()) {
            onLoginFailed();
            return;
        }
        StringRequest stringRequest = new StringRequest(Request.Method.POST, Constant.url_login,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        try {
                            JSONObject jsonObject = new JSONObject(response);
                            String status = jsonObject.getString("status");
                            if(status.equals("sukses")){
                                // kalau berhasil login
                                CreateShared("password","pwdKey",jsonObject.getString("password"));
                                CreateShared("idUser","idKey",jsonObject.getString("id_user"));
                                CreateShared("username","userKey",jsonObject.getString("username"));
                                CreateShared("tipe_user","tipeKey",jsonObject.getString("tipe_user"));
                                Intent intent = new Intent(getApplicationContext(), MainActivity.class);
                                startActivity(intent);
                            }
                            else {
                                Toast.makeText(getApplicationContext(),"Username / Password salah !",Toast.LENGTH_SHORT).show();
                                button.setEnabled(true);
                            }
                        } catch (JSONException e) {
                            e.printStackTrace();
                        }
                    }
                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        System.out.println(error);
                        button.setEnabled(true);
                    }
                }
        ) {
            protected Map<String, String> getParams() {
                Map<String, String> params = new HashMap<String, String>();
                final String token = GetShared("Data_token","Key_token");
                params.put("login", "Login");
                params.put("username", username);
                params.put("password", password);
                params.put("token", token);
                return params;
            }
        };
        RequestQueue requestQueue = Volley.newRequestQueue(this);
        requestQueue.add(stringRequest);
    }
    private String GetShared(String Name, String Key){
        SharedPreferences settings = getSharedPreferences(Name, Context.MODE_PRIVATE);
        String data = settings.getString(Key,"");
        return data;
    }
    private void CreateShared(String PrefName, String KeyName, String Value){
        SharedPreferences sharedpreferences = getSharedPreferences(PrefName, Context.MODE_PRIVATE);
        SharedPreferences.Editor editor = sharedpreferences.edit();
        editor.putString(KeyName,Value);
        editor.commit();
    }

    @Override
    public void onBackPressed() {
        moveTaskToBack(true);
    }
    public void onLoginFailed() {
        Toast.makeText(getBaseContext(), "Gagal Login", Toast.LENGTH_LONG).show();
        button.setEnabled(true);
    }
    public boolean validate() {
        boolean valid = true;

        String email = EditName.getText().toString();
        String password = EditPwd.getText().toString();

        if (email.isEmpty() ) {
            EditName.setError("Username Tidak Boleh Kosong");
            valid = false;
        } else {
            EditName.setError(null);
        }

        if (password.isEmpty() ) {
            EditPwd.setError("Password Tidak Boleh Kosong");
            valid = false;
        } else {
            EditPwd.setError(null);
        }

        return valid;
    }
}
