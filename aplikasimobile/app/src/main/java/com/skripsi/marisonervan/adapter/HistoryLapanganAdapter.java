package com.skripsi.marisonervan.adapter;

import android.app.Activity;
import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.TextView;

import com.skripsi.marisonervan.R;
import com.skripsi.marisonervan.model.ListHistoryLapangan;

import java.util.List;

public class HistoryLapanganAdapter extends BaseAdapter {

    private Activity activity;
    private LayoutInflater layoutInflater;
    private List<ListHistoryLapangan> listHistoryLapangen;

    public HistoryLapanganAdapter(Activity activity, List<ListHistoryLapangan> listHistoryLapangen){
        this.activity = activity;
        this.listHistoryLapangen = listHistoryLapangen;
    }
    @Override
    public int getCount() {
        return listHistoryLapangen.size();
    }

    @Override
    public Object getItem(int position) {
        return listHistoryLapangen.get(position);
    }

    @Override
    public long getItemId(int position) {
        return position;
    }

    @Override
    public View getView(int position, View convertView, ViewGroup parent) {
        if (layoutInflater == null) layoutInflater = (LayoutInflater) activity.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
        if (convertView == null) convertView = layoutInflater.inflate(R.layout.history_lapangan, null);

        TextView NoPolisi = (TextView) convertView.findViewById(R.id.noMobil);
        TextView TglHistory = (TextView) convertView.findViewById(R.id.tglHistory);
        TextView StatusFpk = (TextView) convertView.findViewById(R.id.statusFpk);
        ListHistoryLapangan l = listHistoryLapangen.get(position);

        NoPolisi.setText(l.getNoPolisi());
        TglHistory.setText(l.getTglCari());
        StatusFpk.setText(l.getStatusFpk());


        return convertView;
    }
}
