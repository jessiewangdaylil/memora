<div>
<tr class="shipping_area">
  <td></td>
  <td></td>
  <td>
    <h5 style="margin-bottom: 100px">包裝</h5>
  </td>
  <td>
        <div class="shipping_box">
          <ul class="list">
            <x-select id="package" name="package" :options="['一般','加固','送禮']" class="shipping_select section_bg" />
          </ul>
  </td>
</tr>
<tr class="shipping_area">
  <td></td>
  <td></td>
  <td>
    <h5 style="margin-bottom: 100px">運費</h5>
  </td>
  <td>
        <div class="shipping_box">
          <ul class="list">
            <x-select id="package" name="package" :options="['國內','海外']" class="shipping_select section_bg" />
          </ul>

          <select class="shipping_select">
            <option value="1">Bangladesh</option>
            <option value="2">India</option>
            <option value="4">Pakistan</option>
          </select>

  </td>
</tr>
<tr class="shipping_area">
  <td></td>
  <td></td>
  <td>
   <h6>計算運費: {{}} </h6>
  </td>
  <td>
  </td>
</tr>
</div>
