<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0"  xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="xml" />

    <xsl:template match="/">

<add>
    <xsl:apply-templates select="ead"/>
</add>

     </xsl:template>
    <xsl:template match="ead">
        <!--<xsl:variable name="collectionLink" select="archdesc/dsc/c01/did/ptr/@href"/>-->
		<!-- <xsl:value-of select="concat('http://library.marist.edu/?c=exploro&m=viewEAD&cid=', $folderName, '&id=', $myUnitID)"/>-->
        <xsl:variable name="collection" select="control/filedesc/titlestmt/titleproper"/>
        <xsl:variable name="genreform" select="archdesc/controlaccess/genreform/part"/>
		<xsl:variable name="myUnitID" select="archdesc/did/unitid"/>
		<!-- Getting the folder name for the unittitle, ex LTP -->
		<xsl:variable name="folderName" select="../collectionFolder"/>

		<!-- Used to get collection name ex: Lowell Thomas Papers -->
		<xsl:variable name="myCollection" select="archdesc/dsc/c01/did/unittitle"/>

		<!-- Links to the finding aids -->
		<xsl:variable name="collectionLink">http://library.marist.edu/exploro/?c=exploro<![CDATA[&]]>m=viewEAD<![CDATA[&]]>cid=<xsl:value-of select="$folderName"/><![CDATA[&]]>id=<xsl:value-of select="$myUnitID"/></xsl:variable>
        <doc1>
				<field name="collectionLink">
					<xsl:value-of select="$collectionLink"/>
				</field>

                <xsl:if test="control/filedesc/publicationstmt/publisher">
                        <field name="publisher">
                            <xsl:value-of select="control/filedesc/publicationstmt/publisher"/>
                        </field>
                </xsl:if>
                <xsl:if test="control/filedesc/publicationstmt/date">
                         <field name="publisheddate">
                             <xsl:value-of select="control/filedesc/publicationstmt/date"/>
                         </field>
                </xsl:if>
                <xsl:if test="control/filedesc/publicationstmt/address/addressline">
                         <field name="publisheraddress">
                             <xsl:value-of select="control/filedesc/publicationstmt/address/addressline"/>
                         </field>
                </xsl:if>
                <xsl:if test="archdesc/did/repository/corpname">
                         <field name="corpname">
                              <xsl:value-of select="archdesc/did/repository/corpname"/>
                         </field>
                </xsl:if>
                <xsl:if test="archdesc/did/repository/corpname/address/addressline">
                    <field name="corpaddress">
                        <xsl:value-of select="archdesc/did/repository/corpname/address/addressline"/>
                    </field>
                </xsl:if>
                <xsl:if test="archdesc/did/repository/corpname/@identifier">
                         <field name="corplink">
                             <xsl:value-of select="archdesc/did/repository/corpname/@identifier"/>
                         </field>
                </xsl:if>
                <xsl:if test="archdesc/did/origination/@identifier">
                    <field name="originLink">
                        <xsl:value-of select="archdesc/did/origination/@identifier"/>
                    </field>
                </xsl:if>
                <xsl:if test="archdesc/did/origination/persname">
                    <field name="origination">
                        <xsl:value-of select="archdesc/did/origination/persname/part"/>
                    </field>
                </xsl:if>
                <xsl:if test="archdesc/did/unitdatestructured/daterange/datesingle">
                         <field name="datesingle">
                             <xsl:value-of select="archdesc/did/unitdatestructured/daterange/datesingle"/>
                         </field>
                </xsl:if>
                <xsl:if test="archdesc/did/unitdatestructured/daterange/fromdate">
                         <field name="fromdate">
                             <xsl:value-of select="archdesc/did/unitdatestructured/daterange/fromdate"/>
                         </field>
                </xsl:if>
                <xsl:if test="archdesc/did/unitdatestructured/daterange/todate">
                        <field name="todate">
                            <xsl:value-of select="archdesc/did/unitdatestructured/daterange/todate"/>
                        </field>
                </xsl:if>
                <xsl:if test="archdesc/did/physdescstructured/@physdescstructuredtype">
                    <field name='physdesc'>
                        <xsl:value-of select="archdesc/did/physdescstructured/quantity"/>(<xsl:value-of select="archdesc/did/physdescstructured/unittype"/>)
                    </field>
                </xsl:if>


    <!-- <xsl:template match="/*/*[1]">
        <xsl:variable name="second" select="local-name(following-sibling::*[1])" />
        <xsl:element name="{local-name()}And{$second}">
            <xsl:apply-templates select="node()" />
            <xsl:text> </xsl:text>
            <xsl:apply-templates select="following-sibling::*[1]/node()"/>
        </xsl:element>
    </xsl:template>-->


				<!-- <xsl:template match ="/*/*[1]">
					<xsl:variable name="combinedID" select="unittitle(following-sibling::*[1])" />
					<xsl:element name="{unittitle()}And{$combinedID}">
						<xsl:apply-templates select="node()" />
						<xsl:text> </xsl:text>
						<xsl:apply-templates select="following-sibling::*[1]/node()"/>
					</xsl:element>
				</xsl:template> -->

                <xsl:if test="archdesc/did/unitid">
                    <field name="unitid">
                        <xsl:value-of select="concat($folderName, '.', $myUnitID)"/>
                    </field>
                </xsl:if>
				<field name="collection">
					<xsl:value-of select="$myCollection"/>
				</field>
                <xsl:if test="archdesc/accessrestrict">
                    <field name="accessrestrict">
                        <xsl:value-of select="archdesc/accessrestrict"/>
                    </field>
                </xsl:if>
                <xsl:if test="archdesc/userrestrict">
                    <field name="userrestrict">
                        <xsl:value-of select="archdesc/userrestrict"/>
                    </field>
                </xsl:if>
                <xsl:if test="archdesc/controlaccess/genreform">
                    <field name="genreform">
                        <xsl:value-of select="archdesc/controlaccess/genreform/part"/>
                    </field>
                </xsl:if>
                <xsl:if test="archdesc/controlaccess/geogname">
                    <field name="geogname">
                        <xsl:value-of select="archdesc/controlaccess/geogname/part"/>
                    </field>
                    <field name="geogLink">
                    <xsl:value-of select="archdesc/controlaccess/geogname/@identifier"/>
                </field>
                </xsl:if>
            </doc1>
            <xsl:for-each select=".//*[@level='recordgrp']">
                 <xsl:variable name="container" select="./did/container"/>
                <xsl:for-each select=".//*[@level='item']">
					<xsl:variable name="itemUnitID" select="did/unitid"/>
                    <doc>
						<field name="collectionLink">
						  <xsl:value-of select="$collectionLink"/>
						</field>

            <xsl:variable name="lowercase" select="'abcdefghijklmnopqrstuvwxyz'" />
            <xsl:variable name="uppercase" select="'ABCDEFGHIJKLMNOPQRSTUVWXYZ'" />

            <field name="collection">
                <xsl:value-of select="normalize-space($myCollection)" />
            </field>

            <xsl:variable name="itemGenreForm" select="./controlaccess/genreform/part"/>
            <field name="format">
              <xsl:choose>
              <xsl:when test="concat($genreform, $itemGenreForm)">
                <xsl:if test="$genreform"><xsl:value-of select="translate($genreform, $uppercase, $lowercase)" /></xsl:if> <xsl:if test="./controlaccess/genreform/part"> <xsl:value-of select="concat(' ', $itemGenreForm)"/></xsl:if>
              </xsl:when>
              <xsl:otherwise>N/A</xsl:otherwise>
            </xsl:choose>
            </field>

            <field name="unitid">
                <xsl:value-of select="concat($folderName, '.', $container, '.', $itemUnitID)"/>
            </field>
            <field name="unittitle">
                <xsl:value-of select="./did/unittitle"/>
            </field>
            <!-- Variables required to make all characters in dates lowercase to fight inconsitent data -->
            <xsl:variable name="datesingle" select="did/unitdatestructured/datesingle"/>

            <xsl:if test="./did/unitdatestructured/datesingle">
                <field name="datesingle">
                    <xsl:value-of select="translate(string($datesingle), $uppercase, $lowercase)"/>
                </field>
            </xsl:if>
            <xsl:if test="./did/unitdatestructured/daterange/fromdate">
                <field name="daterange">
                    <xsl:value-of select="./did/unitdatestructured/daterange/fromdate"/>-<xsl:value-of select="./did/unitdatestructured/daterange/todate"/>
                </field>
            </xsl:if>
            <xsl:if test="./physdescstructured/dimensions">
              <field name="dimensions">
                  <xsl:value-of select="./physdescstructured/dimensions"/>
              </field>
            </xsl:if>
						<!-- taken from https://stackoverflow.com/questions/13622338/how-to-implement-if-else-statement-in-xslt -->
						<xsl:choose>
							<xsl:when test="./dao">
								<field name="link">
									<xsl:value-of select="./dao/@href"/>
								</field>
								<field name="category">
									<xsl:value-of select="'Digitized'"/>
								</field>
							</xsl:when>
							<xsl:otherwise>
								<field name="link">
									<xsl:value-of select="'../images/folder-icon.png'"/>
								</field>
								<field name="category">
									<xsl:value-of select="'Non-Digitized'"/>
								</field>
							</xsl:otherwise>
						</xsl:choose>

                        <!--<xsl:if test="./dao">
                            <field name="link">
                                <xsl:value-of select="./dao/@href"/>
                            </field>
							<field name="category">
								<xsl:value-of select="'Digital Object'"/>
							</field>
                        </xsl:if> -->
                        <xsl:if test="./userestrict">
                            <field name="userestrict">
                                <xsl:value-of select="./userestrict"/>
                            </field>
                        </xsl:if>
                    </doc>

                </xsl:for-each>

            </xsl:for-each>

    </xsl:template>




<!--    <xsl:template match="C">
      <doc>
          <xsl:apply-templates/>
          <field name="series">
              <xsl:value-of select="preceding::controlnote/p"/>

          </field>
          <field name="collectionLink">
              <xsl:value-of select="preceding::recordid/@instanceurl"/>
          </field>
          <field name="format">
              <xsl:value-of select="preceding::genreform/part"/><xsl:if test="controlaccess/genreform/part">,<xsl:value-of select="controlaccess/genreform/part"/></xsl:if>
          </field>
      </doc>
    </xsl:template>-->
<!--    <xsl:template>

        <xsl:for-each select="/C/@*[.='item']">
        <xsl:apply-templates/>

    </xsl:for-each>

    </xsl:template>-->
   <!-- <xsl:template match="titleproper">

        <field name="collection"> <xsl:value-of select="."/></field>

    </xsl:template>
    <xsl:template match="repository">

        <field name="corpname"> <xsl:value-of select="part"/></field>

    </xsl:template>


    <xsl:template match="date">
        <field name="date"> <xsl:value-of select="."/></field>
    </xsl:template>
    <xsl:template match="publisher">
        <field name="publisher"> <xsl:value-of select="."/></field>

    </xsl:template>
    <xsl:template match="unitdatestructured">
        <xsl:if test="datesingle">

        <field name="datesingle"> <xsl:value-of select="datesingle"/></field>
        </xsl:if>
        <xsl:if test="daterange/fromdate">

        <field name="fromdate"> <xsl:value-of select="daterange/fromdate"/></field>
        </xsl:if>
        <xsl:if test="daterange/todate">

        <field name="todate"> <xsl:value-of select="daterange/todate"/></field>
        </xsl:if>
    </xsl:template>



    <xsl:template match="profiledesc">
        <field name="profiledesc"> <xsl:value-of select="."/></field>
    </xsl:template>

    <xsl:template match="langusage">
        <field name="langusage"> <xsl:value-of select="."/></field>
    </xsl:template>

    <xsl:template match="recordid">
        <field name="link">
            <xsl:value-of select="@instanceurl"/>
        </field>

        <field name="recordId">
            <xsl:value-of select="."/>
        </field>
    </xsl:template>
    <xsl:template match="address">
        <field name="address"> <xsl:value-of select="."/></field>

    </xsl:template>
    <xsl:template match="ref">

    </xsl:template>
    <xsl:template match="languagedeclaration">

    </xsl:template>
    <xsl:template match="maintenancehistory">

    </xsl:template>
    <xsl:template match="agencycode">
        <field name="agencycode"> <xsl:value-of select="."/></field>

    </xsl:template>

    <xsl:template match="physdescstructured">
        <field name="quantity"> <xsl:value-of select="quantity"/></field>
        <field name="unittype"><xsl:value-of select="unittype"/></field>
    </xsl:template>
    <xsl:template match="repository">
        <field name="corpname"> <xsl:value-of select="corpname/part"/></field>
        <field name="corplink"><xsl:value-of select="corpname/@identifier"/></field>
    </xsl:template>
    <xsl:template match="origination">
        <field name="origination"> <xsl:value-of select="persname/part"/></field>
        <field name="originLink"> <xsl:value-of select="@identifier"/></field>
    </xsl:template>
    <xsl:template match="geogname">
        <field name="geogname"> <xsl:value-of select="part"/></field>
        <field name="geogLink"> <xsl:value-of select="@identifier"/></field>
    </xsl:template>
    <xsl:template match="unittitle">
        <field name="unittitle"> <xsl:value-of select="."/></field>

    </xsl:template>
    <xsl:template match="unitid">
        <field name="collection"><xsl:value-of select="preceding::titleproper"/></field>
        <field name="unitid"> <xsl:value-of select="."/></field>

    </xsl:template>


    <xsl:template match="physdescset">

    </xsl:template>
    <xsl:template match="langmaterial">

    </xsl:template>
    <xsl:template match="physdescstructured">
        <field name="physdesc"> <xsl:value-of select="dimensions"/></field>

    </xsl:template>

    <xsl:template match="container">
        <field name="container"> <xsl:value-of select="."/></field>

    </xsl:template>
    <xsl:template match="agencyname">
        <field name="agencyname"> <xsl:value-of select="."/></field>
    </xsl:template>
    <xsl:template match="dao">

        <field name="link"> <xsl:value-of select="@href"/></field>

    </xsl:template>

    &lt;!&ndash;xsl:template match="archdesc"&ndash;&gt;
    &lt;!&ndash;doc&ndash;&gt;
    <xsl:template match="accessrestrict">
        <field name="accessrestrict">
            <xsl:value-of select="."/>
        </field>
    </xsl:template>
    <xsl:template match="userestrict">
        <field name="userestrict">
            <xsl:value-of select="."/>
        </field>
    </xsl:template>
    <xsl:template match="scopecontent">
        <field name="scopecontent">
            <xsl:value-of select="."/>
        </field>
    </xsl:template>
    <xsl:template match="bioghist">
        <field name="bioghist">
            <xsl:value-of select="."/>
        </field>
    </xsl:template>
    <xsl:template match="controlaccess">
&lt;!&ndash;        <field name="persname">
            <xsl:value-of select="persname"/>
        </field>&ndash;&gt;
        <xsl:if test="geogname/part">

        <field name="geogname">
            <xsl:value-of select="geogname/part"/>
        </field>
        </xsl:if>
        <xsl:if test="geogname/@identifier">

        <field name="geogLink">
            <xsl:value-of select="geogname/@identifier"/>
        </field>
        </xsl:if>
        <xsl:if test="subject">
        <field name="subject">
            <xsl:value-of select="subject"/>
        </field>
        </xsl:if>


    </xsl:template>-->

</xsl:stylesheet>
