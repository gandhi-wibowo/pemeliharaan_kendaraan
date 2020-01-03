package com.skripsi.marisonervan.adapter;

import android.app.Activity;
import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.TextView;

import com.skripsi.marisonervan.R;
import com.skripsi.marisonervan.model.NotificationModel;

import java.util.List;


public class NotificationAdapter extends BaseAdapter {

    private Activity activity;
    private LayoutInflater layoutInflater;
    private List<NotificationModel> notificationList;


    public NotificationAdapter(Activity activity, List<NotificationModel> notificationList){
        this.activity = activity;
        this.notificationList = notificationList;
    }


    @Override
    public int getCount() {
        return notificationList.size();
    }

    @Override
    public Object getItem(int position) {
        return notificationList.get(position);
    }

    @Override
    public long getItemId(int position) {
        return position;
    }

    @Override
    public View getView(int position, View convertView, ViewGroup parent) {
        if (layoutInflater == null) layoutInflater = (LayoutInflater) activity.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
        if (convertView == null) convertView = layoutInflater.inflate(R.layout.list_notification, null);

        TextView NoPolisi = (TextView) convertView.findViewById(R.id.noPolisi);
        TextView JudulNotif = (TextView) convertView.findViewById(R.id.judulNotif);
        TextView PesanNotif = (TextView) convertView.findViewById(R.id.pesanNotifikasi);
        NotificationModel notificationModel = notificationList.get(position);

        NoPolisi.setText(notificationModel.getNoPolisi());
        JudulNotif.setText(notificationModel.getJudulNotif());
        PesanNotif.setText(notificationModel.getPesanNotif());

        return convertView;
    }
}
